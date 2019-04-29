<?php


namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AuthController extends BaseController
{


    /**
     * @Route("/newuser", name="new_user", methods="POST" )
     * @return Response
     */

    public function newuser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');

        $user = new User();
        $user-> setName($username);
        $user->setEmail($email);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setCredit(3);
        $user->setCreatedAt(new \DateTime());
        $em->persist($user);
        $em->flush();

        return $this->json($user);
    }

    public function api()
    {
        return new Response(sprintf('Logged in as %s', $this->getUser()->getUsername()));
    }



}