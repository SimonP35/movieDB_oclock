<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=App\Repository\CastingRepository::class)
 */
class Casting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Assert\Length(min = 2, max = 100)
     * @Groups({"movies_get"})
     */
    private $role;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\NotBlank
     * @Assert\Type("int") 
     * @Assert\Length(max = 2)
     * @Assert\Choice({10, 9, 8, 7, 6, 5, 4, 3, 2, 1}) 
     * @Groups({"movies_get"})
     */
    private $credit_order;

    /**
     * @ORM\ManyToOne(targetEntity=Person::class, inversedBy="castings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"movies_get"})
     */
    private $person;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="castings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $movie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getCreditOrder(): ?int
    {
        return $this->credit_order;
    }

    public function setCreditOrder(int $credit_order): self
    {
        $this->credit_order = $credit_order;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }
}
