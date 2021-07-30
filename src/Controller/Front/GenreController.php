<?php

namespace App\Controller\Front;

use App\Entity\Genre;
use App\Repository\CastingRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * 
 */
class GenreController extends AbstractController
{
    /**
     * Show Genre
     * @Route("/genre/show/{slug}", name="genre_show", )
     */
    public function show(Genre $genre, CastingRepository $castingRepository): Response
    {
        if ($genre === null)
        {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        // $castings = $castingRepository->findAllByMovieJoinedToPersonQB($genre);

        return $this->render('front/genre/show.html.twig', [ 
            'genre' => $genre,
            // 'castings' => $castings
        ]);
    }
}
