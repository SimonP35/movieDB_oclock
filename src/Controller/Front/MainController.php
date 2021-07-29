<?php

namespace App\Controller\Front;

use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 */
class MainController extends AbstractController
{
    /**
     * Page List Home
     * @Route("/", name="home")
     */
    public function list(MovieRepository $mr, GenreRepository $gr): Response
    {
        $movies = $mr->findAll();
        $genres = $gr->findAll();

        return $this->render('front/main/home.html.twig', [
             'movies' => $movies,
             'genres' => $genres 
        ]);
    }
}
