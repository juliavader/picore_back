<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="categories")
     */
    public function getAllCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findAll();

        return $this->json($categories);
    }
}
