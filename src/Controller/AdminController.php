<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Form\AdminType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    /**
     * List of users
     */
    #[Route('/admin', name: 'app_admin')]
    public function list(UserRepository $repository): Response
    {
        // Je récupére toutes les auteurs
        $users = $repository->findAll();

        // Il est possible de récupérer l'entité user qui est connécté
        $user = $this->getUser();

        // J'affiche la liste des auteurs
        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/new', name: 'app_admin_user_new')]
    public function userNew(Request $request, UserRepository $repository): Response
    {
        // je créé le formulaire
        $form = $this->createForm(AdminType::class);

        // je remplie le formulaire avec les données saisie par l'utilisateur
        $form->handleRequest($request);

        // je test si le formulaire a bien était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Je récupére l'auteur du formulaire
            $user = $form
                ->getData();

            // J'enregistre l'auteur dans la base de données
            $repository->save($user, true);

            // je redirige vers la liste des auteurs
            return $this->redirectToRoute('app_admin');
        }

        // j'affiche le formulaire de création d'un auteur
        return $this->render('admin/newUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/user/{id}', name: 'app_admin_user_update')]
    public function update(Request $request, UserRepository $repository, User $user)
    {
        // je créé le formulaire avec l'auteur
        $form = $this->createForm(AdminType::class, $user);

        // je remplie le formulaire avec les données saisie par l'utilisateur
        $form->handleRequest($request);

        // je test si le formulaire a bien était envoyé et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // J'enregistre l'auteur dans la base de données
            $repository->save($user, true);

            // je redirige vers la liste des auteurs
            return $this->redirectToRoute('app_admin');
        }

        // j'affiche le formulaire de création d'un auteur
        return $this->render('admin/modifyUser.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    // /**
    //  * Supprime un auteur
    //  */
    #[Route('/admin/user/{id}/delete', name: 'app_admin_user_delete')]
    public function remove(User $user, UserRepository $repository): Response
    {
        // Je supprime l'auteur
        $repository->remove($user, true);

        // Je redirige vers la liste des auteurs
        return $this->redirectToRoute('app_admin');
    }
}
