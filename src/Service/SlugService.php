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

    /**
     * Méthode transformant une string en slug
     * Générique pour différents objets (utilisées en combinaison avec la méthode __toString())
     * 
     * @return string
     */
    public function toSlug($object): string
    {
        if ($this->toLower) {
            $slug = $this->slugger->slug($object)->lower();
            return $slug;

        } else {
            $slug = $this->slugger->slug($object);
            return $slug;
        }
    }

}