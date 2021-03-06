<?php

namespace App\Controller;

use App\Entity\Activity;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActivityController extends AbstractController
{
    /**
     * @Route("/activites", name="activites")
     */
    public function activites()
    {
        $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Activity::class);
        $activites = $repo->findAll();
        //dd($activites);
        $nosActivites = ['nosActivites'=>$activites];
        return $this->render('activity/activites.html.twig',$nosActivites);
    }
    

  
}
