<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Entity\ActivityExecution;
use DateTime;
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
        $em= $this->getDoctrine()->getManager();
        //====================================================
        //--The activity-execution --selected for inscription --
        $executionId= $req->get('selectedOne'); 
        $selectedActivityExecution = $em
        ->getRepository(ActivityExecution::class)
        ->findOnebyId($executionId);
        //====================================================
        //form to send to the View
        //1.
        $uneParticipation = new Participation();
        //2.
        $formulaireParticipation = $this
        ->createForm(ParticipationType::class, $uneParticipation, ['action' => $this->generateUrl('participation-inscription'), 'method' => 'POST'] );
        //3.
        $formulaireParticipation->handleRequest($req);
       
                    
        if( $formulaireParticipation->isSubmitted() &&  $formulaireParticipation->isValid()){
            $uneParticipation = $formulaireParticipation->getData();
            $typePayement = $formulaireParticipation->get('typePayement')->getData();
            switch($typePayement){
                case 'cash':
                    $uneParticipation->setStatusPayement('non payé');
                    break;
                case 'paypal':
                    $dateTransaction = clone new \DateTimeInterface('now');
                    $uneParticipation->setDatePayement($dateTransaction);
                    
                    $uneParticipation->setStatusPayement('en cours');

                    $activityPrice = $uneParticipation->getActivityExecution()->getActivity()->getPrice();
                    $uneParticipation->setPricePayed($activityPrice);
                    break;
            }
            $em->persist($uneParticipation);
            $em->flush();
            return $this->render('participation/participation-inscription-traitement.html.twig',['participationInserted'=> $uneParticipation /*'execution'=>$selectedActivityExecution*/]);
        }
        
        $toView = [ 'participationForm' => $formulaireParticipation->createView(), 'execution'=>$selectedActivityExecution];
        return $this->render('participation/participation-inscription.html.twig', $toView );
        
    }

}
