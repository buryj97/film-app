<?php

namespace App\Controller;

use App\Form\FilmSearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request, UserRepository $repository): Response
    {
        /** @var User $user */
    $user = $this->getUser();
    $users = $repository->findAll();
        var_dump($users);

        $form = $this->createForm(FilmSearchType::class);

        $form->handleRequest($request);

         return $this->render('search/index.html.twig', 
         [
            'form' => $form->createView(),
            'user' => $user
         ]);
    }   
}
