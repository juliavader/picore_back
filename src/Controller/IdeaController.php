<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\ExCompany;

use App\Entity\ExImages;
use App\Entity\ExUrl;
use App\Entity\Idea;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IdeaController extends BaseController
{

    /**
     * @Route("/api/newIdea", name="new_idea", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function newIdea(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


//        Title
        $title = $request->request->get('title');

//        Description
        $description = $request->request->get('description');



//        User
        $user = $this->getUser();
        $credit = $user->getCredit();
        $credit += 1 ;
        $user->setCredit($credit);


        $newidea = new Idea();
        $newidea-> setName($title);
        $newidea->setDescription($description);

        $newidea->addUser($user);

//        Category
        $categoryId = $request->request->get('category');
        if ($categoryId){
            foreach ($categoryId as $category){
                $category = $em->getRepository(Category::class)->find($category);
                $newidea->addCategory($category);
            }
        }

//        Compagnies
        $Compagnies = $request->request->get('compagny');
        if ($Compagnies){
            foreach ($Compagnies as $Compagny){
                $ExCompagnies = new ExCompany();
                $ExCompagnies->setName($Compagny);
                $newidea->addExCompany($ExCompagnies);
            }
        }

//        Image
        $Images = $request->request->get('image');
        if ($Images){
            foreach ($Images as $Image){
                $ExImage = new ExImages();
                $ExImage->setName($Image);
                $newidea->addExImage($ExImage);
            }
        }

        //       URL
        $urls = $request->request->get('url');
        if ($urls){
            foreach ($urls as $url){
                $exUrl = new ExUrl();
                $exUrl->setName($url);
                $newidea->addExUrl($exUrl);
            }
        }

        $newidea->setDateCreation(new \DateTime());
        $em->persist($newidea);
        $em->flush();

        return $this->serializeEntity($newidea);
    }


    /**
     * @Route("/api/removeIdea", name="remove_idea", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function removeIdea(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


//        Idea
        $IdIdea = $request->request->get('idea');
        $Idea = $em->getRepository(Idea::class)->find($IdIdea);



//          User
        $user = $this->getUser();



        $Idea->removeUser($user);

        $IdCompagnies = $request->request->get('compagny');
        if ($IdCompagnies){
            foreach ($IdCompagnies as $Compagny){
                $ExCompagnies = $em->getRepository(ExCompany::class)->find($Compagny);
                $Idea->removeExCompany($ExCompagnies);
            }
        }

//        Image
        $Images = $request->request->get('image');
        if ($Images){
            foreach ($Images as $Image){
                $ExImage = $em->getRepository(ExImages::class)->find($Image);
                $Idea->removeExImage($ExImage);
            }
        }

//       URL
        $urls = $request->request->get('url');
        if ($urls){
            foreach ($urls as $url){
                $ExUrl = $em->getRepository(ExUrl::class)->find($url);
                $Idea->addExUrl($ExUrl);
            }
        }
        $em->remove($Idea);
        $em->flush();


        return new Response('Idea has been deleted ! ');
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
            ->findAll();
        $shuffle = shuffle($idea);
        $RandomIdea = array_pop($idea);

        return $this->serializeEntity($RandomIdea);
    }


    /**
     * @Route("/specificIdea/{categoryId}", name="oneSpecificIdea", methods="GET")
     * @param $categoryId
     * @return Response
     */

        public function oneSpecificIdea($categoryId):Response
        {
            $Idea = $this->getDoctrine()->getRepository(Idea::class)
                ->createQueryBuilder('i')
                ->select('i ,c')
                ->join('i.categories', 'c')
                ->where('c.id = :categoryId')
                ->setParameter(':categoryId', $categoryId)
                ->getQuery()
                ->getScalarResult();
            $shuffle = shuffle($Idea);
            $specIdea = array_pop($Idea);

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
        $Idea = $this->getDoctrine()->getRepository(Idea::class)
            ->createQueryBuilder('i')
            ->select('i,c')
            ->join('i.categories', 'c')
            ->where('c.id = :categoryId')
            ->orwhere('c.id = :subCategoryId')
            ->setParameter(':categoryId', $categoryId)
            ->setParameter(':subCategoryId',$subCategoryId)
            ->getQuery()
            ->getScalarResult();
        $shuffle = shuffle($Idea);
        $specIdea = array_pop($Idea);
        return $this->json($specIdea);
    }









}
