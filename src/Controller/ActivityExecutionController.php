<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Activity;
use App\Entity\ActivityExecution;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActivityExecutionController extends AbstractController
{
    

     /**
     * @Route("/activity/executions", name="activity-executions")
     * 
     */
    public function activityExecutions(Request $req)
    {
        // LIMITER ACCES SI PAS ROLE_USER :  CREER SESSIONINTERFACE & ACCES DENIED...
        $today= date("Y-m-d H:i:s");
        $activityId= $req->get('activityId'); 
        $em = $this->getDoctrine()->getManager();
        dump($activityId);
        dump($today);
        
        //--The activityExecutions --selected by User --
        $repoAcEx = $em->getRepository(ActivityExecution::class);
        $activityExecutions = $repoAcEx->findAllByActivityId($activityId, $today);
        dd($activityExecutions);
        return $this->render('activity_execution/activity-executions.html.twig', ['activityExecutions'=>$activityExecutions]);
    }

      /**
     * @Route("/activity/execution/inscription", name="execution-inscription")
     * 
     */
    public function activityExecutionInscription(Request $req)
    { 
        /*
        ///1.  ACCES DENIED----> SI PAS ROLE_USER <---> USERFormulaireROLE
        ///2.  ACCES DENIED----> SI PAS ROLE_USER_PARENT <---> CHILDFormulaire
        ///3.  INSCRIPTION_EXECUTION----> <---> PARTICIPATIONFormulaire
        //---------------------------------------------------------------------
        //--The activity-execution --selected for inscription --
        $executionId= $req->get('selectedOne');      
        $em = $this->getDoctrine()->getManager()->getRepository(ActivityExecution::class);
        $activityExecution = $em->findOnebyId($executionId);
        
        // // if (!empty(user->getchildren() ){
        $participationForm = $this->forward('App\Controller\ParticipationController:participationInscription', ['execution_id'=> $executionId]);
        
        //dd( $activityExecution);
        return $this->render('activity_execution/activity-execution-inscription.html.twig', ['participationForm'=>$participationForm, 'execution'=>$activityExecution]);
        
        // }
        // //else{

        //}
        
        */
    }


}
