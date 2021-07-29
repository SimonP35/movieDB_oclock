<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Repository\CastingRepository;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;

/**
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
     * Show Movie
     * @Route("/movie/show/{id<\d+>}", name="movie_show")
     */
    public function show(Movie $movie, CastingRepository $castingRepository)
    {
        if ($movie === null) 
        {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        // $castings = $castingRepository->findBy(
        //     ["movie" => $movie],
        //     ["credit_order" => "ASC"]
        // );

        // $castings = $castingRepository->findAllByMovieJoinedToPersonDQL($movie);
        $castings = $castingRepository->findAllByMovieJoinedToPersonQB($movie);

        // dump($movie);
        // dump($casting);

        return $this->render('front/movie/show.html.twig', [ 
            'movie' => $movie,
            'castings' => $castings
        ]);
    }
}
