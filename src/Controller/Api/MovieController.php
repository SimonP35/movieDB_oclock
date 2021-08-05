<?php

namespace App\Controller\Api;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        
        return $this->json(['movies' => $movies,], Response::HTTP_OK, [], ['groups' => 'movies_get']);
    }

    /**
     * Get a movie by id
     * 
     * @Route("/api/movies/{id<\d+>}", name="api_movies_show", methods="GET")
     */
    public function show(Movie $movie): Response
    {       
        if (null === $movie) {

            $error = 'Ce film n\'existe pas';

            return $this->json(['error' => $error], Response::HTTP_NOT_FOUND);
        }

        return $this->json(['movie' => $movie], Response::HTTP_OK, [], ['groups' => 'movies_get']);
    }

    /**
     * Create a new movie
     * 
     * @Route("/api/movies", name="api_movies_post", methods="POST")
     */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $vi): Response
    {
        $jsonContent = $request->getContent();

        $movie = $serializer->deserialize($jsonContent, Movie::class, 'json');

        $errors = $vi->validate($movie);

        // dd($errors);

        $newErrors = [];

        foreach ($errors as $i => $error) {
            $newErrors[$i] = [$error->getPropertyPath(), $error->getMessage()];
        }

        // dd($newErrors);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;
    
            // return new Response($errorsString);
            return $this->json(['newErrors' => $newErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
            // return $this->json(['errorsString' => $errorsString], Response::HTTP_UNPROCESSABLE_ENTITY, [], []);
        }
    
        $em->persist($movie);
        $em->flush();

        return $this->json(['movie' => $movie], Response::HTTP_CREATED, ['Location' => $this->generateUrl( 'api_movies_show', [ 'id' => $movie->getId()] )], ['groups' => 'movies_get']);

        // return $this->redirectToRoute('api_movies_show', [ 'id' => $movie->getId()], Response::HTTP_CREATED);

    }

    /**
     * Edit a movie
     * 
     * @Route("/api/movies/{id<\d+>}", name="api_movies_edit", methods={"PUT", "PATCH"})
     */
    public function edit(Request $request, Movie $movie = null, SerializerInterface $serializer, EntityManagerInterface $em, ValidatorInterface $vi): Response
    {
        if (null === $movie) {

            $error = 'Ce film n\'existe pas';

            return $this->json(['error' => $error], Response::HTTP_NOT_FOUND);
        }

        //TODO : Pour PUT, s'assurer qu'on ait un certain nombre de champs sinon => 422 HTTP_UNPROCESSABLE_ENTITY
        //TODO : Pour PATCH, s'assurer qu'on au moins un champ sinon => 422 HTTP_UNPROCESSABLE_ENTITY

        $jsonContent = $request->getContent();

        $movie = $serializer->deserialize($jsonContent, Movie::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $movie]);

        $errors = $vi->validate($movie);

        // dd($errors);

        $newErrors = [];

        foreach ($errors as $error) {
            $newErrors[$error->getPropertyPath()][] = $error->getMessage();
        }

        // dd($newErrors);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            
            $errorsString = (string) $errors;
                
            // return new Response($errorsString);
            // return $this->json(['errorsString' => $errorsString], Response::HTTP_UNPROCESSABLE_ENTITY);

            return $this->json(['newErrors' => $newErrors], Response::HTTP_UNPROCESSABLE_ENTITY);

        }
    
        $em->flush();

        //TODO : Conditionner le message de retour au cas l'entité ne serait pas modifiée

        return $this->json(['movie' => $movie], Response::HTTP_OK, ['Location' => $this->generateUrl( 'api_movies_show', [ 'id' => $movie->getId()] )], ['groups' => 'movies_get']);

        // return $this->redirectToRoute('api_movies_show', [ 'id' => $movie->getId()], Response::HTTP_CREATED);

    }

    /**
     * Delete a movie
     * 
     * @Route("/api/movies/{id<\d+>}", name="api_movies_delete", methods="DELETE")
     */
    public function delete(Movie $movie = null, EntityManagerInterface $em)
    {
        if ( null === $movie ) {

            $error = 'Ce film n\'existe pas';

            return $this->json(['error' => $error], Response::HTTP_NOT_FOUND);
        }
    
        $em->remove($movie);
        $em->flush();

        $remove = "Le film a bien été supprimé.";

        return $this->json(['remove' => $remove], Response::HTTP_OK);
    }

}
