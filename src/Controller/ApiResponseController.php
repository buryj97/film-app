<?php

namespace App\Controller;

use Error;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiResponseController extends AbstractController
{

     private $entityManager;

    
   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/update-saved-films", name="update_saved_films", methods={"POST"})
     */

     public function updateSavedFilms(Request $request, UserRepository $repository)
{
    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    /** @var User $user */
    $user = $this->getUser();

    if ($request->isMethod('POST')) {
        // Get the data from the request
        $favData = json_decode($request->getContent(), true);

        // Retrieve the existing savedFilms array
        $savedFilms = $user->getSavedFilms();

        $filmExists = false;
        $filmIndex = null;

        // Check if the film already exists in the saved films array
        foreach ($savedFilms as $index => $film) {
            if ($film['title'] === $favData['title']) {
                $filmExists = true;
                $filmIndex = $index;
                break;
            }
        }

        if ($filmExists) {
            // Remove the existing film from the array
            unset($savedFilms[$filmIndex]);
        } else {
            // Add the new film to the array
            $savedFilms[] = $favData;
        }

        // Set the updated savedFilms array to the user
        $user->setSavedFilms(array_values($savedFilms)); // Reset array keys
        $repository->save($user, true);

        return new JsonResponse(['message' => 'Data saved successfully'], 200);
    } else {
        return new Error("Please login to save to your watchlist");
    }
}

    /**
     * @Route("/get-saved-films", name="get_saved_films", methods={"GET"})
     */

     public function getSavedFilms()
     {
    
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        /** @var User $user */
        $user = $this->getUser();

        $savedFilms = $user->getSavedFilms();

        $jsonResponse = $this->json($savedFilms);

        return $jsonResponse;
    }
}

