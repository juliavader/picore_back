<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function getAllCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->createQueryBuilder('c')
            ->select('c')
            ->getQuery()
            ->getScalarResult();

        return $this->json($categories);
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
            ->getScalarResult();

        return $this->json($subcategory);
    }




}
