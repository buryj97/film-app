<?php

namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Logout\LogoutUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/logout', name: 'app_logout')]
    //  public function logout(Request $request, LogoutUrlGenerator $logoutUrlGenerator): Response
    // {
    //     // Invalidate the user's session
    //     $request->getSession()->invalidate();

    //     // Get the firewall name
    //     $firewallName = 'main';

    //     // Generate the logout URL
    //     $logoutUrl = $logoutUrlGenerator->getLogoutUrl($firewallName);

    //     // Redirect to the login page
    //     return new RedirectResponse($logoutUrl);
    // }
    public function logout(Security $security): Response
    {
        // disable the csrf logout
        $response = $security->logout(false);
        // redirect to login
        $response = $this->redirectToRoute('app_login');
        return $response;
    }
}
