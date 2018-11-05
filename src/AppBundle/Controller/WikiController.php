<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
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
     * @Route("/{categoryId}", requirements={"categoryId": "\d+"}, name="app.wiki.category")
     * @param Request $request
     * @param null $categoryId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mainAction(Request $request, $categoryId = null)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 20);
        $text = $request->query->get('text', '');

        $form = $this->createForm(SearchWikiFormType::class, null, [
            'action' => $this->generateUrl('app.wiki.main'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $text = $form->get('text')->getData();
        }

        $articles = $this->getDoctrine()->getRepository(Wiki::class)
            ->findWikiByText($categoryId, $text, $page, $limit);

        return $this->render('wiki/main.html.twig', [
            'form' => $form->createView(),
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{articleId}", name="app.wiki.article")
     * @param Request $request
     * @param $articleId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function articleAction(Request $request, $articleId)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Wiki::class)
            ->findOneBy(['id' => $articleId]);

        if (!$article) {
            $this->createNotFoundException();
        }

        $comment = new Comment();
        $comment->setWiki($article);
        $comment->setUser($this->getUser());
        $form = $this->createForm(CommentFormType::class, $comment, [
            'action' => $this->generateUrl('app.wiki.article', ['articleId' => $articleId])
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app.wiki.article', ['articleId' => $articleId]);
        }

        $comments = $em->getRepository(Comment::class)
            ->findBy(['wiki' => $article]);

        return $this->render('wiki/article.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    public function categoryAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findCategoriesByGroupSubCategory();

        return $this->render("wiki/category.html.twig", [
            'categories' => $categories,
        ]);
    }
}
