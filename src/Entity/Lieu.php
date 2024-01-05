<?php

namespace App\Entity;

use App\Repository\LieuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LieuRepository::class)]
class Lieu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Releves::class, mappedBy: 'lieu')]
    private Collection $releves;

    public function __construct()
    {
        $this->releves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection|Releves[]
     */
    public function getReleves(): Collection
    {
        return $this->releves;
    }

    public function addReleve(Releves $releve): self
    {
        if (!$this->releves->contains($releve)) {
            $this->releves[] = $releve;
            $releve->setLieu($this);
        }

        return $this;
    }

    public function removeReleve(Releves $releve): self
    {
        if ($this->releves->removeElement($releve)) {
            // set the owning side to null (unless already changed)
            if ($releve->getLieu() === $this) {
                $releve->setLieu(null);
            }
        }

        return $this;
    }
}
