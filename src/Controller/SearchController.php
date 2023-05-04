<?php

namespace App\Controller;

use App\Form\FilmSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function search(Request $request): Response
{
    $form = $this->createForm(FilmSearchType::class);

    $form->handleRequest($request);

    // $client = HttpClient::create();

    // $movies = [];
    // $searchTerms = [];

    // if ($form->isSubmitted() && $form->isValid()) {
    //     $searchTerms = explode(' ', $form->getData()['searchTerms']);
        
    //     foreach ($searchTerms as $searchTerm) {
    //         $response = $this->$client->request('GET', 'https://streaming-availability.p.rapidapi.com/v2/search/basic', [
    //             'query' => [
    //                 'apikey' => '8d0b2a5100msh66455e428ed9568p197a01jsnb5d4ac778dbc',
    //                 'apihost' => 'streaming-availability.p.rapidapi.com',
    //                 's' => $searchTerm
    //             ]
    //         ]);
            
    //         $responseData = json_decode($response->getContent(), true);
            
    //         if(isset($responseData['Search'])) {
    //             foreach($responseData['Search'] as $movie) {
    //                 $movies[] = $movie;
    //             }
    //         }
    //     }
    // }
    
    return $this->render('search/index.html.twig', [
        'form' => $form->createView(),
        // 'movies' => $movies,
        // 'searchTerms' => $searchTerms
    ]);
}

}
