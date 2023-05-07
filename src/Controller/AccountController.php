<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(UserRepository $repository): Response
    {
        // $user = $repository->getUser();
        $streamingServices = $repository->findAll();

        return $this->render('account/index.html.twig', [
            // 'user' => $user,
            'streamingServices' => $streamingServices
        ]);
    }
     #[Route('/account', name: 'app_modify_account')]
    public function profil(Request $request, UserRepository $repository): Response
    {
        // Je créé le formulaire avec l'utilisateur connécté
        $form = $this->createForm(ProfilType::class, $this->getUser());

        // Je remplie le formulaire avec les données saisie par l'utilisateur
        $form->handleRequest($request);

        // Je test si le form est envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // J'enregistre l'utilisateur dans le dépot des users
            $repository->save($this->getUser(), true);

            // @TODO Je redirige vers la page d'accueil
            return new Response('Ok');
        }

        // J'affiche le formulaire d'édition de profil
        return $this->render('account/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
