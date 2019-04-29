<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Idea;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends BaseController
{

    /**
     * @Route("/newIdea", name="new_idea", methods="POST" )
     * @return Response
     */

    public function newIdea(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $title = $request->request->get('title');
        $description = $request->request->get('description');
        $categoryId = $request->request->get('category');
        $category = $em->getRepository(Category::class)->find($categoryId);
//        $user = $request->request->get('user');

        $newidea = new Idea();
        $newidea-> setName($title);
        $newidea->setDescription($description);
//        $newidea->setUser($user);
        $newidea->setDateCreation(new \DateTime());
        $em->persist($newidea);
        $em->flush();

        return $this->json($newidea);
    }


    /**
     * @Route("/countAllIdeas", name="countAllIdeas", methods="GET")
     */
    public function Counting()
    {
        $ideas = $this->getDoctrine()->getRepository(Idea::class)
            ->createQueryBuilder('i')
            ->select('Count(i.id)')
            ->getQuery()
            ->getSingleScalarResult();


    return $ideas;
    }

    /**
     * @Route("/randomIdea", name="randomIdea", methods="GET")
     */
    public  function getonebyRandom():Response
    {
        $idea = $this->getDoctrine()->getRepository(Idea::class)
            ->findOneBy([ 'id' => RAND(1, $this->Counting()) ]);

        return $this->serializeEntity($idea);
    }


    /**
     * @Route("/specificIdea/{categoryId}", name="oneSpecificIdea", methods="GET")
     * @param $categoryId
     * @return Response
     */

        public function oneSpecificIdea($categoryId):Response
        {
            $specIdea = $this->getDoctrine()->getRepository(Idea::class)
                ->createQueryBuilder('i')
                ->select('i ,c')
                ->join('i.categories', 'c')
                ->where('c.id = :categoryId')
                ->setMaxResults(1)
                ->setParameter(':categoryId', $categoryId)
                ->getQuery()
                ->getScalarResult();

        return $this->json($specIdea);
    }




    /**
     * @Route("/specificIdea/{categoryId}/{subCategoryId}", name="twoSpecificationsForIdea", methods="GET")
     * @param $categoryId
     * @param $subCategoryId
     * @return Response
     */

    public function twoSpecificationsForIdea($categoryId, $subCategoryId):Response
    {
        $specIdea = $this->getDoctrine()->getRepository(Idea::class)
            ->createQueryBuilder('i')
            ->select('i,c')
            ->join('i.categories', 'c')
            ->where('c.id = :categoryId')
            ->orwhere('c.id = :subCategoryId')
            ->setParameter(':categoryId', $categoryId)
            ->setParameter(':subCategoryId',$subCategoryId)
            ->getQuery()
            ->getScalarResult();

        return $this->json($specIdea);
    }


    /**
     * @Route("/addFavorite", name="favorite", methods="POST" )
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





}
