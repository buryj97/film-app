<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Security $security): Response
    {
        // disable the csrf logout
        $response = $security->logout(false);
        // redirect to login
        $response = $this->redirectToRoute('app_login');
        return $response;
    }
}
