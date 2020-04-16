<?php

namespace App\Controller;

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
        $activityId= $req->request->get('activityId'); // null ????????????????????????????????????????????????????????
        dd($activityId);
        $em = $this->getDoctrine()->getManager();
        dd($em);
        $repo = $em->getRepository(ActivityExecution::class);
        
        //$activityExecutions = $repo->findAllByIdActivity($activityId); // methode queryBuilder "custum" ne fonctionne pas
        $activityExecutions2 = $repo->findBy(['activity_id'=> $activityId]);
        return $this->render('activity_execution/une-activite.html.twig');
    }
}
