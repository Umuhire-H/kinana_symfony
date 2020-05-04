<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TranslationController extends AbstractController
{
    /**
     * @Route("/traductions", name="translations")
     */
    public function translations()
    {
        return $this->render('translation/translations.html.twig');
    }
}
