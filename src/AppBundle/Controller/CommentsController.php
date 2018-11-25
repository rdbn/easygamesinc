<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends Controller
{
    /**
     * @Route("/comment/check/{wikiId}", requirements={"wikiId": "\d+"}, name="app.comments.check_comments")
     * @param Request $request
     * @param $wikiId
     * @return Response
     */
    public function checkCommentsAction(Request $request, $wikiId)
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirect($request->headers->get('referer'));
        }

        $user = $this->getUser();
        $checkComments = $user->getCheckComments();
        unset($checkComments[$wikiId]);
        $user->setCheckComments($checkComments);

        $this->getDoctrine()->getManager()->flush();

        return $this->json(['status' => 'success']);
    }

    /**
     * @Route("/comment/check/id/{wikiId}/{commentId}", requirements={"wikiId": "\d+"}, name="app.comments.check_comment.id")
     * @param $wikiId
     * @param $commentId
     * @return Response
     */
    public function checkCommentAction($wikiId, $commentId)
    {
        $user = $this->getUser();
        $checkComments = $user->getCheckComments();
        unset($checkComments[$wikiId][array_search($commentId, $checkComments)]);
        $user->setCheckComments($checkComments);

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app.user.comments');
    }
}