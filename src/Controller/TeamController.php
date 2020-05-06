<?php

namespace App\Controller;

// use Symfony\Component\Security\Core\User\User;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function allTeammate()
    {
        $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(User::class);
        $team = $repo->findTeam();
        // dd($team);
        return $this->render("team/team.html.twig", ['team'=>$team]);
      
    }
}
