<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Wiki;
use AppBundle\Form\CommentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WikiController extends Controller
{
    /**
     * @Route("/", name="app.wiki.main")
     * @Route("/{wikiId}", requirements={"wikiId": "\d+"}, name="app.wiki.wiki")
     * @param Request $request
     * @param null $wikiId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request, $wikiId = null)
    {
        $categoryList = $this->get('app.service.category_list')
            ->listCategories();

        $em = $this->getDoctrine()->getManager();
        $wiki = $em->getRepository(Wiki::class)
            ->findOneWikiByDefaultOrWikiId($wikiId);

        if ($wiki) {
            $comment = new Comment();
            $comment->setWiki($wiki);
            $comment->setUser($this->getUser());
            $form = $this->createForm(CommentFormType::class, $comment, [
                'action' => $this->generateUrl('app.wiki.wiki', ['wikiId' => $wiki->getId()])
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($comment);
                $em->flush();

                return $this->redirectToRoute('app.wiki.wiki', ['wikiId' => $wiki->getId()]);
            }

            $comments = $em->getRepository(Comment::class)
                ->findBy(['wiki' => $wiki], ['createdAt' => 'DESC']);
        }

        return $this->render('wiki/main.html.twig', [
            'form' => isset($form) ? $form->createView() : false,
            'comments' => isset($comments) ? $comments : false,
            'listWiki' => $categoryList['listWiki'],
            'refWiki' => $categoryList['refWiki'],
            'wiki' => $wiki,
        ]);
    }
}
