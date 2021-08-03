<?php

namespace App\EventListener;

use App\Entity\Movie;
use App\Service\SlugService;

class MovieListener
{
    private $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function toSlug(Movie $movie): void
    {
        $movie->setSlug($this->slugService->toSlug($movie));
    }
}