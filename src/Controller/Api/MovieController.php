<?php

namespace App\Controller\Api;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * Get movies collection
     * 
     * @Route("/api/movies", name="api_movies_get", methods="GET")
     */
    public function index(MovieRepository $mr): Response
    {
        $movies = $mr->findAll();

        return $this->json(['movies' => $movies,], 200, [], ['groups' => 'movies_get']);
    }
}
