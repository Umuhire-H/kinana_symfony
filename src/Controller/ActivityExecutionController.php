<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\ActivityExecution;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActivityExecutionController extends AbstractController
{
    

     /**
     * @Route("/une/activite", name="une-activite")
     * 
     */
    public function uneActivite(Request $req)
    {
        
        $activityId= $req->get('activityId'); // ok
        $activityDescription= $req->get('activityDescription'); // ok
        //dump($activityDescription);
        //dd($activityId);
        $em = $this->getDoctrine()->getManager();

        //--The activityExecution --selected by User --
        $repoAcEx = $em->getRepository(ActivityExecution::class);
        $activityExecutions = $repoAcEx->findAllByIdActivity($activityId);
        //dump($activityExecutions);

        //--the Activity associated --
        $repoAc = $em->getRepository(Activity::class);
        $activityAssociated = $repoAc->findOneById($activityId);
        //dd($activityAssociated);
        //--
        $arrayObject = [];
        array_push($arrayObject, $activityExecutions);
        array_push($arrayObject, $activityAssociated);
        dd($arrayObject); 
        return $this->render('activity_execution/une-activite.html.twig');
    }
}
