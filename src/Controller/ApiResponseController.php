<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiResponseController extends AbstractController
{
    private $entityManager;

    /**
     * @Route("/update-saved-films", name="update_saved_films", methods={"POST"})
     */
   
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updateSavedFilms(Request $request)
    {
        // Get the data from the request
        $data = json_decode($request->getContent(), true);
        var_dump($data);

        /** @var $user User */

        $user = $this->getUser();

        if($user){
             $user->setSavedFilms([$data['title'], $data['overview'], $data['runtime'], $data['directors'], $data['year'], $data['streamingServices'], $data['posterPath']]);


        // Persist the entity to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Data saved successfully'], 200);
        } else {
            return new Error("Please login to save to your watchlist");
        }

       


    }
    
}

