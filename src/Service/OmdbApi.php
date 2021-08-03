<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Service qui cause à OMDB API
 */
class OmdbApi
{
    /**
     * Client HTTP pour l'exécution des requetes
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchMoviePoster($movie): array
    {
        $response = $this->client->request(
            "GET",
            "https://www.omdbapi.com/?apiKey=83bfb8c6&t=$movie"
        );

        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    /**
     * Renvoie l'URL du poster
     * 
     * @param string $title Titre du film
     * @return null|string
     */
    public function fetchPoster($movie)
    {
        $content = $this->fetchMoviePoster($movie);

        // Clé Poster existe ?
        if (array_key_exists('Poster', $content)) {
            return $content['Poster'];
        }

        return 'http://lorempixel.com/300/400/';
    }

}
