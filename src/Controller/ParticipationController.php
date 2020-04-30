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
        //$this->denyAccessUnlessGranted('ROLE_PARENT','ROLE_MEMBRE','ROLE_USER' );
        //
        $connectedUser = $this->getUser();
        $today = new DateTime('now');
        $em= $this->getDoctrine()->getManager();       
        $uneParticipation = new Participation();
        // $executionId= $req->get('selectedOne'); 
        // dd($req->getData);       
        // dd($executionId);
        if(!is_null($req->get('selectedOne'))){
            $executionId= $req->get('selectedOne'); 
            //dd($executionId);
            //====================================================
            //==form to send to the View ==           
            //==The activity-execution-selected ==for inscription ==
            $selectedActivityExecution = $em
            ->getRepository(ActivityExecution::class)
            ->findOnebyId($executionId);
            
            $price=$selectedActivityExecution->getActivity()->getPrice();
            $uneParticipation->setPricePayed($price);
            //2. form de TYPE participationType
            $formulaireParticipation = $this->createForm(ParticipationType::class, $uneParticipation, [
                'action' => $this->generateUrl('participation-inscription'), 
                'method' => 'POST', 
                'user'=> $connectedUser,
                'selectedActivity' => $selectedActivityExecution] );  //dump($formulaireParticipation);     
            //3. form
        }
        else
        {
            $formulaireParticipation = $this->createForm(ParticipationType::class, $uneParticipation, [
                'action' => $this->generateUrl('participation-inscription'), 
                'method' => 'POST', 
                'user'=> $connectedUser,
                /*'selectedActivity' => $selectedActivityExecution*/] );  //dump($formulaireParticipation);     
            // $executionId= $req->get('selectedOne'); 
            //3. form
        }
        
        $formulaireParticipation->handleRequest($req);     

        if( $formulaireParticipation->isSubmitted() /*&& $formulaireParticipation->isValid()*/){
            $uneParticipation = $formulaireParticipation->getData();       //dd($formulaireParticipation);

            // target ===================================================            
             $isUsertargeted = $formulaireParticipation->get('target')->getData();// bool 
             if($isUsertargeted)
             {
                 $uneParticipation->setUser($connectedUser);
             }
            //activityexecution================================================
            $form_widget_ActivityExecution_id = $formulaireParticipation->get('activityExecution')->getViewData();         
           
            $finalizedActivityExecution = $em
                ->getRepository(ActivityExecution::class)
                ->findOnebyId($form_widget_ActivityExecution_id);    //dump($finalizedActivityExecution);

            $uneParticipation->setActivityExecution($finalizedActivityExecution);            
            
            // --Payement ========================================================
            $typePayement = $formulaireParticipation->get('typePayement')->getData();  // dd($typePayement);
            $uneParticipation->setTypePayement($typePayement);
            switch($typePayement)
            {
                case 'cash':
                    $uneParticipation->setStatusPayement('unpaid');
                    break;
                case 'paypal':
                    // $dateTransaction = clone new \DateTimeInterface('now');
                    $uneParticipation->setStatusPayement('in process');
                    $uneParticipation->setDatePayement($today);                    

                    $activityPrice = $uneParticipation->getActivityExecution()->getActivity()->getPrice();
                    $uneParticipation->setPricePayed($activityPrice);
                    break;
            }
            // dump($uneParticipation);
            // dump($formulaireParticipation->get('child')->getData());
            // dd($uneParticipation->getChild());
                     
            $em->persist($uneParticipation);

            $em->flush();
            
                       
            return $this->render('participation/participation-inscription-traitement.html.twig',['participationInserted'=> $uneParticipation , 'execution'=>$finalizedActivityExecution]);
        }
        else{                       
            $toView = [ 'participationForm' => $formulaireParticipation->createView(), 'execution'=>$selectedActivityExecution];
            return $this->render('participation/participation-inscription.html.twig', $toView );
            
        }
        
    }

    /**
     * @Route("/participation/inscription/payement", name="payement-paypal")
     */
    public function participationInscriptionPayement(Request $req) //# (Request $req)
    {
        //$this->denyAccessUnlessGranted('ROLE_PARENT','ROLE_MEMBRE, ROLE_USER' );
        //
        $em= $this->getDoctrine()->getManager();
        $selectedActivityExecution = $em
            ->getRepository(ActivityExecution::class)
            ->findOnebyId($req->get('selectedOne'));
        return $this->render('participation/payement-paypal.html.twig', ['payedExecution' => $selectedActivityExecution] );
        
    }
}
