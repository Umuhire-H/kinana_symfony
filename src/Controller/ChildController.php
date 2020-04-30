<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChildController extends AbstractController
{
    /**
     * @Route("/child/inscription", name="child-inscription")
     */
    public function inscription(Request $req)
    {
        $oneChild = new Child();
        $formChild = $this->createForm(ChildType::class, $oneChild, [
            'action' => $this->generateUrl('child-inscription'),
            'method' => 'POST',
        ] );
        $formChild->handleRequest($req);
        if($formChild->isSubmitted() && $formChild->isValid()){
            $oneChild = $formChild->getData();
        }
        return $this->render('child/child-inscription.html.twig', [
            'controller_name' => 'ChildController',
        ]);
    }
}
