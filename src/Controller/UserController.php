<?php

namespace App\Controller;

use App\Form\SignUpType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function signUp(UserRepository $repository, Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $form = $this->createForm(SignUpType::class);
        $form->getErrors(true);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $user->getPassword();
            $cryptedPassword = $encoder->hashPassword($user, $password);
            $user->setPassword($cryptedPassword);
            
            $user->setRoles(["ROLE_USER"]);

            $repository->save($user, true);

            return $this->redirectToRoute('app_login');
        }
   
        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
}