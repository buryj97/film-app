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
    /**
     * @Route("/update-saved-films", name="update_saved_films", methods={"POST"})
     */
    public function updateSavedFilms(Request $request)
    {
        // Get the data from the request
        $data = json_decode($request->getContent(), true);
        
        // Process the data or perform any necessary operations
        // ...
        
        // Return a JSON response
        return new JsonResponse(['message' => 'Data received successfully'], 200);
    }
//     private $entityManager;

    
   
//     public function __construct(EntityManagerInterface $entityManager)
//     {
//         $this->entityManager = $entityManager;
//     }

//     /**
//      * @Route("/update-saved-films", name="update_saved_films", methods={"POST"})
//      */
//     public function updateSavedFilms(Request $request)
//     {
//         // Get the data from the request
//         $data = json_decode($request->getContent(), true);
//         if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
//         return new JsonResponse(['error' => 'Invalid JSON data'], 400);
// }


//         /** @var $user User */

//         $user = $this->getUser();

//         if($user){
//              $user->setSavedFilms([$data['title'], $data['overview'], $data['runtime'], $data['directors'], $data['year'], $data['streamingServices'], $data['posterPath']]);


//         // Persist the entity to the database
//         $this->entityManager->persist($user);
//         $this->entityManager->flush();

//         return new JsonResponse(['message' => 'Data saved successfully'], 200);
//         } else {
//     return new Error("Please login to save to your watchlist");
// }

       


//     }
    
}

