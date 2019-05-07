<?php

namespace App\Controller;


use App\Entity\ExUrl;
use App\Entity\Idea;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExUrlController extends BaseController
{
    /**
     * @Route("/newUrl", name="new_url", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function newUrl($UrlName, $IdIdea){

        $em = $this->getDoctrine()->getManager();


//        Name
        $name = $UrlName;

//        Idea
        $Idea = $em->getRepository(Idea::class)->findBy($IdIdea);

        $newUrl = new ExUrl();
        $newUrl->setName($name);
        $newUrl->setIdea($Idea);

        $em->persist($newUrl);
        $em->flush();

        return $this->serializeEntity($newUrl);
    }


}
