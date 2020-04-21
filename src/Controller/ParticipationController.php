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
        $this->getUser();
        $em= $this->getDoctrine()->getManager();
        
        //==TodayDate ==
        //$today = new \DateTimeInterface('now');
        $today = new DateTime('now');

        //====================================================
        //==form to send to the View ==
        //1. vide
        $uneParticipation = new Participation();

        //2. form de TYPE participationType
        $connectedUser = $this->getUser();
        $connectedUserChildren = $connectedUser->getChildren();
        if(isset($connectedUser) && isset($connectedUserChildren)){ // tous ayant enfant 
            //dd($theActiveUser);
            $formulaireParticipation = $this->createForm(ParticipationType::class, $uneParticipation, [
                'action' => $this->generateUrl('participation-inscription'), 
                'method' => 'POST', 
                'user'=> $connectedUser] );       
        }
        else{
            $formulaireParticipation = $this
            ->createForm(ParticipationType::class, $uneParticipation, ['action' => $this->generateUrl('participation-inscription'), 'method' => 'POST'] );       
        }
        //3. form
        $formulaireParticipation->handleRequest($req);
                    
        if( $formulaireParticipation->isSubmitted() && $formulaireParticipation->isValid()){
            
            $uneParticipation = $formulaireParticipation->getData();
            $idActivityExecution = $req->get('idActivityExecution');

            $typePayement = $formulaireParticipation->get('typePayement')->getData();
            switch($typePayement){
                case 'cash':
                    $uneParticipation->setStatusPayement('unpayed');
                    break;
                case 'paypal':
                   // $dateTransaction = clone new \DateTimeInterface('now');
                    $uneParticipation->setDatePayement($today);                    
                    $uneParticipation->setStatusPayement('in process');

                    $activityPrice = $uneParticipation->getActivityExecution()->getActivity()->getPrice();
                    $uneParticipation->setPricePayed($activityPrice);
                    break;
            }
            //dd($formulaireParticipation->get('child')->getData());
            //--obtenir activityExecution de la DB
            $selectedActivityExecution = $em
            ->getRepository(ActivityExecution::class)
            ->findOnebyId($idActivityExecution);
            $uneParticipation->setActivityExecution($selectedActivityExecution);
            //--child

            $em->persist($uneParticipation);
            $em->flush();
           
            return $this->render('participation/participation-inscription-traitement.html.twig',['participationInserted'=> $uneParticipation , 'execution'=>$selectedActivityExecution]);
        }
        else{
            //====================================================
            //==The activity-execution --selected for inscription ==
            $executionId= $req->get('selectedOne'); 
            $selectedActivityExecution = $em
                ->getRepository(ActivityExecution::class)
                ->findOnebyId($executionId);
            //
            
            $toView = [ 'participationForm' => $formulaireParticipation->createView(), 'execution'=>$selectedActivityExecution];
            return $this->render('participation/participation-inscription.html.twig', $toView );
            
        }
        
    }

}
