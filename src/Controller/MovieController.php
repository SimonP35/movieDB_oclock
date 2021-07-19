<?php

namespace App\Controller;

use DateTime;
use App\Entity\Movie;
use App\Repository\CastingRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Contrôleur en mode "sandbox" (bac à sable, on joue ;))
 * 
 * Browse => Liste les enregistrements
 * Read => lit un enregistrement
 * Edit => met à jour
 * Add => ajoute
 * Delete => supprime
 */
class MovieController extends AbstractController
{
    /**
     * Page List Movie
     * @Route("/movie/list", name="movie_list")
     */
    public function list(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findAll();
        // dump($movies);

        return $this->render('movie/list.html.twig', [ 'movies' => $movies ]);
    }

    /**
     * Read Movie
     * @Route("/movie/show/{id<\d+>}", name="movie_show")
     */
    public function show($id, MovieRepository $movieRepository, CastingRepository $castingRepository)
    {
        $movie = $movieRepository->find($id);
        $castings = $castingRepository->findBy(
            ["movie" => $movie->getId()],
            ["credit_order" => "ASC"]
        );

        // dump($movie);
        // dump($casting);

        return $this->render('movie/show.html.twig', [ 'movie' => $movie, 'castings' => $castings]);
    }

}
