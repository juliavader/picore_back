<?php

namespace App\Controller;


use App\Entity\ExCompany;
use App\Entity\Idea;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExCompagnyController extends BaseController
{
    /**
     * @Route("/newCompagny", name="new_compagny", methods="POST" )
     * @param Request $request
     * @return Response
     */

    public function newCompagny(Request $request){

        $em = $this->getDoctrine()->getManager();


//        Name
        $name = $request->request->get('name');

//        Idea
        $idIdea = $request->request->get('idIdea');
        $Idea = $em->getRepository(Idea::class)->find($idIdea);

        $newCompagny = new ExCompany();
        $newCompagny->setName($name);
        $newCompagny->setIdea($Idea);

        $em->persist($newCompagny);
        $em->flush();

        return $this->serializeEntity($newCompagny);
    }


}
