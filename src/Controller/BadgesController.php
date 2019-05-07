<?php

namespace App\Controller;

use App\Entity\Badges;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BadgesController extends BaseController
{
    /**
     * @Route("/badges", name="AllBadges")
     */
    public function getAllCategories()
    {
        $badges = $this->getDoctrine()->getRepository(Badges::class)
            ->findAll();


        return $this->json($badges);
    }

    /**
     * @Route("/newbadge", name="new_badge", methods="POST" )
     * @return Response
     */

    public function newbadge(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $badgeName= $request->request->get('badge');
        $newbadge = new Badges();
        $newbadge->setName($badgeName);
        $em->persist($newbadge);
        $em->flush();

        return $this->json($newbadge);
    }

}