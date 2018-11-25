<?php
/**
 * Created by PhpStorm.
 * User: rdbn
 * Date: 25/11/2018
 * Time: 19:39
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends Controller
{
    /**
     * @Route("/user", name="app.user.comments")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userCommentsAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        $idsComments = [];
        foreach ($user->getCheckComments() as $checkComment) {
            $idsComments = array_merge($checkComment);
        }

        if (count($idsComments) > 0) {
            $comments = $this->getDoctrine()->getRepository(Comment::class)
                ->findCommentById($idsComments);
        }

        return $this->render('wiki/user_comments.html.twig', [
            'comments' => isset($comments) ? $comments : [],
        ]);
    }

    /**
     * @Route("/user/change-password", name="app.user.change_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user, [
            'action' => $this->generateUrl('app.user.change_password'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $user->getPlainPassword()));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('app.user.change_password');
        }

        return $this->render('wiki/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}