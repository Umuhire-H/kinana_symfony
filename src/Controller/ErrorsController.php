<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ErrorsController extends AbstractController
{
    /**
     * @Route("/error", name="error-page")
     */
    public function errorPage(Request $req)
    {
        $error = $req->get('message');
        // dd($error);
        return $this->render('errors/error-page.html.twig', [
            'error' => $error  ]);
    }
}
