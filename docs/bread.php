<?php

namespace App\Controller\Back;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    /**
     * Lister les films
     *
     * @Route("/back/movie/browse", name="back_movie_browse", methods={"GET"})
     */
    public function browse()
    {
    }

    /**
     * Afficher un film
     *
     * @Route("/back/movie/read/{id}", name="back_movie_read", methods={"GET"})
     */
    public function read()
    {
    }

    /**
     * Ajouter un film
     *
     * @Route("/back/movie/add", name="back_movie_add", methods={"GET", "POST"})
     */
    public function add()
    {
    }

    /**
     * Editer un film
     * 
     * @Route("/back/movie/edit/{id}", name="back_movie_edit", methods={"GET","POST"})
     */
    public function edit()
    {
    }

    /**
     * Supprimer un film
     * => en GET à convertir en POST ou mieux en DELETE
     * 
     * @Route("/back/movie/delete/{id<\d+>}", name="back_movie_delete", methods={"GET"})
     */
    public function delete()
    {
    }
}