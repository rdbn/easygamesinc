<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Wiki;
use AppBundle\Form\CommentFormType;
use AppBundle\Form\SearchWikiFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WikiController extends Controller
{
    /**
     * @Route("/", name="app.wiki.main")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request)
    {
        $text = $request->query->get('text', '');

        $form = $this->createForm(SearchWikiFormType::class, null, [
            'action' => $this->generateUrl('app.wiki.main'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $text = $form->get('text')->getData();
        }

        $wikis = $this->getDoctrine()->getRepository(Wiki::class)
            ->findWikiByText($text);

        $listWiki = [];
        $refWiki = [];
        foreach ($wikis as $wiki) {
            if ($wiki->getParent() == 0) {
                $listWiki[$wiki->getId()] = $wiki;
            } else {
                $refWiki[$wiki->getParent()][] = $wiki;
            }
        }

        return $this->render('wiki/main.html.twig', [
            'form' => $form->createView(),
            'listWiki' => $listWiki,
            'refWiki' => $refWiki,
        ]);
    }

    /**
     * @Route("/wiki/{wikiId}", name="app.wiki.wiki")
     * @param Request $request
     * @param $wikiId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function wikiAction(Request $request, $wikiId)
    {
        $em = $this->getDoctrine()->getManager();
        $wiki = $em->getRepository(Wiki::class)
            ->findOneBy(['id' => $wikiId]);

        if (!$wiki) {
            $this->createNotFoundException();
        }

        $comment = new Comment();
        $comment->setWiki($wiki);
        $comment->setUser($this->getUser());
        $form = $this->createForm(CommentFormType::class, $comment, [
            'action' => $this->generateUrl('app.wiki.wiki', ['wikiId' => $wikiId])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app.wiki.wiki', ['wikiId' => $wikiId]);
        }

        $comments = $em->getRepository(Comment::class)
            ->findBy(['wiki' => $wiki]);

        return $this->render('wiki/wiki.html.twig', [
            'form' => $form->createView(),
            'wiki' => $wiki,
            'comments' => $comments,
        ]);
    }
}
