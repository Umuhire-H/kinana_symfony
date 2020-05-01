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
        $oneChild->addUserParent($this->getUser());
        
        $formChild = $this->createForm(ChildType::class, $oneChild, [
            'action' => $this->generateUrl('child-inscription'),
            'method' => 'POST',
            // 'parent' => $this->getUser(),
        ] );

        $formChild->handleRequest($req);
        if($formChild->isSubmitted() /*&& $formChild->isValid()*/){

            $oneChild = $formChild->getData();

            $oneChild->addUserParent($this->getUser());

            $em= $this->getDoctrine()->getManager();
            $em->persist($oneChild);

            $em->flush();
            
            return $this->redirectToRoute('area_user');
        }
        $toView = [ 'formChild' => $formChild->createView()];
        return $this->render('child/child-inscription.html.twig', $toView);
    }
}
