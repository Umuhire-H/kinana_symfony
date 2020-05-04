<?php

namespace App\Controller;

use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function index()
    {
        $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $team = $repo->findTeam();
        return $this->render("team/team.html.twig", ['team'=>$team]);
      
    }
}
