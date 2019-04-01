<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @property  User
 */
class UserController extends BaseController
{
    /**
     * @Route("/users", name="users-list", methods="GET")
     */
    public function index(): Response
    {

        $users = $this->getDoctrine()->getRepository(User::class)
            ->createQueryBuilder('u')
            ->getQuery()
            ->getArrayResult();


        return $this->json($users);

    }

    /**
     * @Route("/user/{id}", name="unique_user", methods="GET")
     * @param $id
     * @return Response
     */
    public function GetOneByID($id): Response
    {
        $users =  $this->getDoctrine()
            ->getRepository(User::class)
            ->findOneById($id);

        return $this->json($users);
    }

    /**
     * @Route("/user/{id}/Lesscredit", name="update_less_credit", methods="POST" )
     * @param $id
     * @return Response
     */
    public function UpdateLessCredit($id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $credit = $user->getCredit();
        $credit -= 1 ;
        $user->setCredit($credit);
        $entityManager->flush();

        return $this->json('changes updated !');
    }

    /**
     * @Route("/user/{id}/Morecredit", name="update_more_credit", methods="POST" )
     * @param $id
     * @return Response
     */
    public function UpdateMoreCredit($id): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $credit = $user->getCredit();
        $credit += 1 ;
        $user->setCredit($credit);
        $entityManager->flush();

        return $this->json('changes updated !');
    }


//    /**
//     * @Route("/new/user", name="new_user", methods="POST" )
//     * @return Response
//     */
//
//    public function NewUser(Request $request)
//    {
//        $data = $request->getContent();
//        $jsonData = json_decode($data, true);
//
//        $em = $this->getDoctrine()->getManager();
//        $person = new User();
//        $person->setName($jsonData['name']);
//        $person->setEmail($jsonData['email']);
//        $person->setCreatedAt(new \DateTime());
//        $person->setCredit(3);
//        $person->setPassword($jsonData['password']);
//        $em->persist($person);
//        $em->flush();
//
//        return $this->json('you did it ! ');
//    }



}
