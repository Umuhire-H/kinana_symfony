<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation/inscription", name="participation-inscription")
     */
    public function participationInscription($execution_id) //# (Request $req)
    {
        //$activityExecution_id = $req->get('selectedAE_id');
        //$activityExecution_id = $execution_id;
        //$selectedAE_id = $req->get('selectedAE_id');
        
        //dd($selectedAE_id);
        //dd($activityExecution_id);
        
        $em = $this->getDoctrine()->getManager()->getRepository(Participation::class);
        $uneParticipation= $em->findOneByChildExecutionId($execution_id);
        //dd($uneParticipation);

        $formulaireParticipation = $this->createForm(ParticipationType::class, $uneParticipation );
        return  $formulaireParticipation->createView();
        // $toView = [ 'participationForm' => $formulaireParticipation->createView()];
        // return $this->render('participation/participation-inscription.html.twig', $toView );
    }
}
