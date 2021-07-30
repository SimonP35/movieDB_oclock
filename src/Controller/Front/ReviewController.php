<?php

namespace App\Controller\Front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewController extends AbstractController
{
    /**
     *
     * Add Review
     * @Route("/review/add/{slug}", name="add_review", methods={"GET", "POST"})
     */
    public function add(Movie $movie = null, Request $request): Response
    {
        if ($movie === null) 
        {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        $form = $this->createForm(ReviewType::class, $review = new Review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $review->setMovie($movie);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($review);
            $manager->flush();

            dump($review);

            // $this->addFlash('success', 'Votre commentaire a bien été ajouté !');

            return $this->redirectToRoute('movie_show', ['slug' => $movie->getSlug()]);
        }

        return $this->render('front/review/form.html.twig', [ 'movie' => $movie, 'form' => $form->createView()]);
    }
}
