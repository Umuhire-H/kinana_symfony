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
        //==The activity-execution --selected for inscription ==
        $executionId= $req->get('selectedOne'); 
        $selectedActivityExecution = $em
            ->getRepository(ActivityExecution::class)
            ->findOnebyId($executionId);
        //==TodayDate ==
        //$today = new \DateTimeInterface('now');
        $today = new DateTime('now');

        //====================================================
        //==form to send to the View ==
        //1. vide
        $uneParticipation = new Participation();
        //2. form de TYPE participatonType
        $formulaireParticipation = $this
        ->createForm(ParticipationType::class, $uneParticipation, ['action' => $this->generateUrl('participation-inscription'), 'method' => 'POST'] );
        /* J'AIMERAIS ICI :
        2.1 AJOUTER au [formulaire avant de l'affiche] des valeurs par defaut 
                (c'est-à-dire : les enfants du user,l'activité selectionnée, la date d'aujourd'hui))
            * Que choisir ? ==ChoicesType['data'=> ...'Choice_label' ...'data'...'select name'...'option value'
            * exemples: ->setChild($this->user->getChildren , 
                        ->setactivityExecution($selectedActivityExecution->getActivity()->getName())
                        ->setInscriptionDate($today)
            *action à lancer: https://127.0.0.1:8000/activites ---puis--> btn 'participer'  ---puis--> btn 'Confirmer'
            
        2.2 : CACHER des champs (TWIG function? ou TYPE options ?)
        2.3 : CREER mes propre type / ENUM pour les choix ?
        */    
        //3. form
        $formulaireParticipation->handleRequest($req);
                    
        if( $formulaireParticipation->isSubmitted() &&  $formulaireParticipation->isValid()){
            
            $uneParticipation = $formulaireParticipation->getData();
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
            $em->persist($uneParticipation);
            $em->flush();
            return $this->render('participation/participation-inscription-traitement.html.twig',['participationInserted'=> $uneParticipation /*'execution'=>$selectedActivityExecution*/]);
        }
        
        $toView = [ 'participationForm' => $formulaireParticipation->createView(), 'execution'=>$selectedActivityExecution];
        return $this->render('participation/participation-inscription.html.twig', $toView );
        
    }

}
