<?php

namespace App\Controller;

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
        $users = $repository->findAll();

        return $this->render('admin/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/user/new', name: 'app_admin_user_new')]
    public function userNew(Request $request, UserRepository $repository): Response
    {
        $form = $this->createForm(AdminType::class);
        $form->getErrors(true);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form
                ->getData();

            $repository->save($user, true);

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/newUser.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    // /**
    //  * Modify a user
    //  */

    #[Route('/admin/user/{id}', name: 'app_admin_user_update')]
    public function update(Request $request, UserRepository $repository, User $user)
    {
        $form = $this->createForm(AdminType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($user, true);

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/modifyUser.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    // /**
    //  * Delete a user
    //  */
    #[Route('/admin/user/{id}/delete', name: 'app_admin_user_delete')]
    public function remove(User $user, UserRepository $repository): Response
    {
        $repository->remove($user, true);

        return $this->redirectToRoute('app_admin');
    }
}
