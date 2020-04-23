<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $req): Response
    {
      
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        $response = new JsonResponse(['lastUsername' => $lastUsername]);
        if(!is_null($error)){
            $response = new JsonResponse([
                'error' => 'Email ou mot de passe incorrect',
                'lastUsername' => $lastUsername
            ]);
        }
        
        return $response;
        // return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/deconnexion", name="logout")
     */
    public function logout()
    {
        // throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

     /**
     * @Route("/au/revoir")
     */
    public function auRevoir()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN' );
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        return $this->render('security/au-revoir.html.twig');
        
    }
}
