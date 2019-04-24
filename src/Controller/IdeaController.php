<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Idea;
use  App\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends BaseController
{
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

        return $this->json($idea);
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
            ->select('i ,c')
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
     * @Route("/subcategory/{categoryId}", name="getSubcategorybyCategory", methods="GET")
     * @param $categoryId
     * @return Response
     */


    public function getAllSubcategorybyCategory($categoryId){

        $subcategory = $this->getDoctrine()->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->select('c')
            ->where('c.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->getQuery()
            ->getArrayResult();

        return $this->json($subcategory);
    }



 }
