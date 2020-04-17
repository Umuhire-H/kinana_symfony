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
     * @Route("/activite", name="activite")
     * 
     */
    public function uneActivite(Request $req)
    {
        // LIMITER ACCES SI PAS ROLE_USER / CREER SESSIONINTERFACE & ACCES DENIED...
        $today= date("Y-m-d H:i:s");
        $activityId= $req->get('activityId'); 
        //dd($activityId);
        $em = $this->getDoctrine()->getManager();

        //--The activityExecution --selected by User --
        $repoAcEx = $em->getRepository(ActivityExecution::class);
        $activityExecutions = $repoAcEx->findAllByActivityId($activityId, $today);
        //dump($activityExecutions);
        return $this->render('activity_execution/activite.html.twig', ['activityExecutions'=>$activityExecutions]);
    }

      /**
     * @Route("/activite/inscription", name="activite-inscription")
     * 
     */
    public function activiteInscription(Request $req)
    { 
        // LIMITER ACCES SI PAS ROLE_USER <- CREER SESSIONINTERFACE & ACCES DENIED...
        ///1. $user > repoUser > findAllCustum > user.childer :pour formInscription<- classe formulaire
        $selectedActivityExecutionId= $req->get('selectedOne'); 
        //dd($selectedActivityExecutionId);
        //------------test----------------------------------
        
        //dd($activityId);
        $em = $this->getDoctrine()->getManager();

        //--The activityExecution --selected by User --
        $repoUser = $em->getRepository(User::class);
       
        return $this->render('activity_execution/activite.html.twig', ['activityExecutions'=>$activityExecutions]);
    }


}
