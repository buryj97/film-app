<?php

namespace App\Controller;

use App\Form\FilmSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
    {
        $form = $this->createForm(FilmSearchType::class);
        $form->getErrors(true);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        return $this->render('search/index.html.twig', 
         [
            'form' => $form->createView()
         ]);
    }

         return $this->render('search/index.html.twig', 
         [
            'form' => $form->createView()
         ]);
    }   
}
