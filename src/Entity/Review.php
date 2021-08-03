<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * 
     * @Assert\NotBlank
     * @Groups({"movies_get"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     *     
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"movies_get"})
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     * 
     * @Assert\NotBlank
     * @Assert\Length(min = 100)
     * @Groups({"movies_get"})
     */
    private $content;

    /**
     * @ORM\Column(type="smallint")
     * 
     * @Assert\NotBlank
     * @Assert\Choice({5, 4, 3, 2, 1}) 
     * @Groups({"movies_get"})
     */
    private $rating;

    /**
     * @ORM\Column(type="json")
     * 
     * @Assert\NotBlank
     * @Assert\Choice({"smile", "cry", "think", "sleep", "dream"}, multiple=true) 
     * @Groups({"movies_get"})
     */
    private $reactions = [];

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"movies_get"})
     */
    private $watchedAt;

    /**
     * @ORM\ManyToOne(targetEntity=Movie::class, inversedBy="reviews")
     */
    private $movie;

    /**
     * @ORM\Column(type="datetime", options={"default" : "CURRENT_TIMESTAMP"})
     * @Groups({"movies_get"})
     */
    private $publishedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getReactions(): ?array
    {
        return $this->reactions;
    }

    public function setReactions(array $reactions): self
    {
        $this->reactions = $reactions;

        return $this;
    }

    public function getWatchedAt(): ?\DateTime
    {
        return $this->watchedAt;
    }

    public function setWatchedAt(\DateTime $watchedAt): self
    {
        $this->watchedAt = $watchedAt;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}