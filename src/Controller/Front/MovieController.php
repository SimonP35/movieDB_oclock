<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Repository\CastingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 */
class MovieController extends AbstractController
{
    /**
     * Show Movie
     * @Route("/movie/show/{slug}", name="movie_show", )
     */
    public function show(Movie $movie, CastingRepository $castingRepository): Response
    {
        if ($movie === null)
        {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        $castings = $castingRepository->findAllByMovieJoinedToPersonQB($movie);

        return $this->render('front/movie/show.html.twig', [ 
            'movie' => $movie,
            'castings' => $castings
        ]);
    }
}
