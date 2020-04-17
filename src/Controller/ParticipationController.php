<?php

namespace App\Controller;

use App\Form\ParticipationType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation/inscription", name="participation-inscription")
     */
    public function index()
    {
        $formulaireParticipation = $this->createForm(ParticipationType::class);
        $toView = [ 'participationForm' => $formulaireParticipation->createView()];
        return $this->render('participation/index.html.twig', $toView );
    }
}
