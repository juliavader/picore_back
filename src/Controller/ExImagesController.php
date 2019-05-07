<?php

namespace App\Controller;


use App\Entity\ExImages;
use App\Entity\Idea;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExImagesController extends BaseController
{
    /**
     * @Route("/newImage", name="new_image", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function newImage(Request $request){

        $em = $this->getDoctrine()->getManager();


//        Name
        $name = $request->request->get('name');

//        Idea
        $idIdea = $request->request->get('idIdea');
        $Idea = $em->getRepository(Idea::class)->find($idIdea);

        $newImage = new ExImages();
        $newImage->setName($name);
        $newImage->setIdea($Idea);

        $em->persist($newImage);
        $em->flush();

        return $this->serializeEntity($newImage);
    }


}
