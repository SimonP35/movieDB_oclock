<?php

namespace App\EventListener;

use App\Entity\Movie;
use App\Service\SlugService;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CreateMovieSlug
{
    private $slugService;

    public function __construct(SlugService $slugService)
    {
        $this->slugService = $slugService;
    }

    public function prePersist(Movie $movie, LifecycleEventArgs $event): void
    {
        $movie->setSlug($this->slugService->toSlug($movie));
    }

    public function preUpdate(Movie $movie, LifecycleEventArgs $event): void
    {
        $movie->setSlug($this->slugService->toSlug($movie));
    }
}