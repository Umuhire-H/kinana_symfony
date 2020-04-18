<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Entity\ActivityExecution;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation/inscription", name="participation-inscription")
     */
    public function participationInscription(Request $req) //# (Request $req)
    {
        //--The activity-execution --selected for inscription --
        $executionId= $req->get('selectedOne'); 
        $selectedActivityExecution = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository(ActivityExecution::class)
            ->findOnebyId($executionId);
        $uneParticipation = new Participation();
        $formulaireParticipation = $this
            ->createForm(ParticipationType::class, $uneParticipation )
            ->createView();
        $toView = [ 'participationForm' => $formulaireParticipation, 'execution'=>$selectedActivityExecution];
        return $this->render('participation/participation-inscription.html.twig', $toView );
        //=========================================================
        // //==TEST AVEC CHILD_ID = 1  && PARTICIPATION FROM DB ===
        //=========================================================
        // // // // $childId=1;
        // // // // $childSelected = $em->getRepository(Child::class)->find($childId);
        // // // // $uneParticipation= $em->getRepository(Participation::class)->findOneByChildExecutionId($executionId, $childSelected);

        // // // // $formulaireParticipation = $this->createForm(ParticipationType::class, $uneParticipation )->createView();
        // // // // //dd($uneParticipation);

        // // // // $toView = [ 'participationForm' => $formulaireParticipation, 'execution'=>$selectedActivityExecution];
        // // // // return $this->render('participation/participation-inscription.html.twig', $toView );
        // // // // //==============================================
        // =========================================================
    }

}
