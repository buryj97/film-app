<?php

namespace App\Controller;

use LogicException;
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

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $user->getPassword();
            $cryptedPassword = $encoder->hashPassword($user, $password);
            $user->setPassword($cryptedPassword);

            $repository->save($user, true);
        }
        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

}
