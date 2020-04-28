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

    // /**
    //  * @Route("/area/user", name="area_user")
    //  */
    // public function index()
    // {
    //     return $this->render('area_user/index.html.twig', [
    //         'controller_name' => 'AreaUserController',
    //     ]);
    // }
}
