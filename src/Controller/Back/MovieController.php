<?php

namespace App\Controller\Back;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    /**
     * List Movie
     * @Route("back/movie/list", name="back_movie_list")
     */
    public function list(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('back/movie/list.html.twig', [
             'movies' => $movies 
        ]);
    }

    /**
     *
     * Add Movie
     * @Route("back/movie/add", name="back_movie_add", methods={"GET", "POST"})
     */
    public function add(Request $request): Response
    {
        $movie = new Movie();

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($movie);
            $manager->flush();

            $messages = [
                'You did it! You updated the system! Amazing!',
                'That was one of the coolest updates I\'ve seen all day!',
                'Great work! Keep going!',
            ];

            $this->addFlash('success', $messages[array_rand($messages)]);

            // $this->addFlash('success', 'Le film ' . $movie->getTitle() . ' a bien été ajouté !');

            return $this->redirectToRoute('back_movie_list');
        }

        return $this->render('back/movie/add.html.twig', ['form' => $form->createView()]);
    }

    /**
     *
     * Add Movie
     * @Route("back/movie/edit/{id<\d+>}", name="back_movie_edit", methods={"GET", "POST"})
     */
    public function edit(Movie $movie = null, Request $request): Response
    {
        if ($movie === null) {
            throw $this->createNotFoundException('Film non trouvé.');
        }

        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($movie);
            $manager->flush();

            $this->addFlash('success', 'Le film ' . $movie->getTitle() . ' a bien été modifié !');

            return $this->redirectToRoute('back_movie_edit', [ 'id' => $movie->getId() ]);
        }

        return $this->render('back/movie/edit.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Delete Movie
     * @Route("back/movie/delete/{id<\d+>}", name="back_movie_delete")
     */
    public function delete(Movie $movie = null, EntityManagerInterface $entityManager): Response
    {
        if ($movie === null) {
            throw $this->createNotFoundException('Article non trouvé.');
        }

        $entityManager->remove($movie);
        $entityManager->flush();

        $this->addFlash('success', 'Le film a bien été supprimé !');

        return $this->redirectToRoute('back_movie_list');
}

}
