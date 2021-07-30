<?php 

namespace App\Service;

use Symfony\Component\String\Slugger\SluggerInterface;

class SlugService
{
    private $slugger;

    private $toLower;

    public function __construct(SluggerInterface $slugger, bool $toLower)
    {
        $this->slugger = $slugger;
        $this->toLower = $toLower; 
    }

    // Générique pour différents objets (avec leurs méthodes)
    public function toSlug($object): ?string
    {
        if ($this->toLower) {

            $slug = $this->slugger->slug($object)->lower();
            return $slug;
        }
    }

}