<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AreaUserController extends AbstractController
{
    /**
     * @Route("/area/user", name="area_user")
     */
    public function parent()
    {
        return $this->render('area_user/parent.html.twig');
    }

    // //=====================================================
    // //========= test 2 : forward ==========================
    // //=====================================================
    /**
     * @Route("/parent/add/child", name="parent-add-child")
     */
    public function addChild()
    {
        return $this->forward('App\Controller\ChildController:child-inscription');
    }
}
