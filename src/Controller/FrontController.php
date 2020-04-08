<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    /**
     * @Route("/home")
     */
    public function Home()
    {
        return $this->render('front/index.html.twig');
    }

    /**
     * @Route("/about")
     */
    public function About()
    {
        return $this->render('front/about.html.twig');
    }
}
