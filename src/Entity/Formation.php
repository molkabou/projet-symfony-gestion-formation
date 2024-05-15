<?php

namespace App\Entity;

use App\Entity\Participant;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $begin_at = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;
 /**
     * @ORM\OneToMany(targetEntity=Participant::class, mappedBy="formation", cascade={"remove"})
     */
    private $participants;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }
 /**
     * @return Collection|Participant[]
     */
    public function getParticipants(): Collection
    {
        return $this->participants ?? new ArrayCollection();
    }

public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getBeginAt(): ?\DateTimeImmutable
    {
        return $this->begin_at;
    }

    public function setBeginAt(\DateTimeImmutable $begin_at): static
    {
        $this->begin_at = $begin_at;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
    

}