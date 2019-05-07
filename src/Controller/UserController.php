<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
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
            ->findAll();

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


    /**
     * @Route("/addFavorite", name="favorite", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function AddFavorite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ideaId = $request->request->get('idea');
        $idea = $em->getRepository(Idea::class)->find($ideaId);
        $userid = $request->request->get('user');
        $user = $em->getRepository(User::class)->find($userid);


        $addFavorite = $user->addFavoriteIdea($idea);
        $em->persist($addFavorite);
        $em->flush();

        return $this->serializeEntity($addFavorite);
    }

    /**
     * @Route("/api/getAllFavoritesByUser", name="getAllFavoritesByUser", methods="GET" )
     * @param Request $request
     * @return Response
     */

    public function getAllFavoritesByUser(Request $request)
    {
        $getFavorites = $this->getUser()->getFavoriteIdeas();

        return $this->serializeEntity($getFavorites);
    }


    /**
     * @Route("/api/getAllIdeasByUser", name="getAllIdeasByUser", methods="GET" )
     * @param Request $request
     * @return Response
     */

    public function getAllIdeasByUser(Request $request)
    {

        $getIdeas = $this->getUser()->getIdeas();

        return $this->serializeEntity($getIdeas);
    }




}
