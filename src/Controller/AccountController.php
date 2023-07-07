<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(UserRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $streamingServices = $repository->findAll();

        $savedFilms = $repository->findAll();

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'streamingServices' => $streamingServices,
            'savedFilms' => $savedFilms
        ]);


    }
    #[Route('/account/modify', name: 'app_account_modify')]
    public function modifyProfile(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $repository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User|null $user */
        $user = $this->getUser(); // Assuming you have a user object

        if ($request->isMethod('POST')) {

            $firstName = $request->request->get('firstName');
            $user->setFirstName($firstName);

            $lastName = $request->request->get('lastName');
            $user->setLastName($lastName);

            $email = $request->request->get('email');
            $user->setEmail($email);

            $country = $request->request->get('country');
            $user->setCountry($country);

            $streamingServices = $request->request->get('streamingServices', []);
            $user->setStreamingServices($streamingServices);

            $password = $request->request->get('password');
            $cryptedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($cryptedPassword);

            $repository->save($user, true);

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/modifyAccount.html.twig', [
        ]);

    }

    /**
 * @Route("/remove-film", name="remove_film", methods={"GET|POST"})
 */
public function removeFilm(Request $request, UserRepository $repository)
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    /** @var User $user */
    $user = $this->getUser();

    // Retrieve the existing savedFilms array
    $savedFilms = $user->getSavedFilms();

    $filmExists = false;
    $filmIndex = null;

    // Get the film title from the request
    $filmTitle = $request->get('title');

    // Check if the film already exists in the saved films array
    foreach ($savedFilms as $index => $film) {
        if ($film['title'] === $filmTitle) {
            $filmExists = true;
            $filmIndex = $index;
            break;
        }
    }

    if ($filmExists) {
        // Remove the existing film from the array
        unset($savedFilms[$filmIndex]);
    }

    // Set the updated savedFilms array to the user
    $user->setSavedFilms(array_values($savedFilms)); // Reset array keys
    $repository->save($user, true);

    return $this->redirectToRoute('app_account');
}

}