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
        $today= date("Y-m-d H:i:s");
        $activityId= $req->get('activityId'); 
        $em = $this->getDoctrine()->getManager();
               
        //--The activityExecutions --selected by User --
        $repoAcEx = $em->getRepository(ActivityExecution::class);
        $activityExecutions = $repoAcEx->findAllByActivityId($activityId, $today);
        //dd($activityExecutions);
        return $this->render('activity_execution/activity-executions.html.twig', ['activityExecutions'=>$activityExecutions]);
    }

   


}
