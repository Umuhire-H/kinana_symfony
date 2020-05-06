<?php

namespace App\Controller;

use App\Entity\Text;
use App\Repository\TextRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    /**
     * @Route("/traductions", name="translations")
     */
    public function translations()
    {
        $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Text::class);
        $translations = $repo->findAllTranslations();
        //dd($translations);
        if (!is_null($translations)) {
            return $this->render('translation/translations.html.twig', ['translations' => $translations]);
           
        }
        return $this->forward('App\Controller\ErrorsController:errorPage', ['message'=> 'Aucune traduction disponible. En cours...']);
    }

    /**
     * @Route("/traduction", name="translation")
     */
    public function translation(Request $req)
    {
       //dd($req);
        $em = $this->getDoctrine()->getManager();
               
        $repoText = $em->getRepository(Text::class);
        $oneTranslation = $repoText->findThisById($req->get('translationId'));
        // dd($oneTranslation);
        $otherTranslations = $repoText->findAllExcept($req->get('translationId'));
        
        if (!is_null($oneTranslation) && !is_null($otherTranslations)) {
            return $this->render('translation/translation.html.twig', ['translation' => $oneTranslation, 'translations' => $otherTranslations]);
           
        }
        return $this->forward('App\Controller\ErrorsController:errorPage', ['message'=> 'Traduction en cours de modification.']);
    }
}
