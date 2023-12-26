<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Artiste::class)]
    private Collection $genreArtiste;

    public function __construct()
    {
        $this->genreArtiste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Artiste>
     */
    public function getGenreArtiste(): Collection
    {
        return $this->genreArtiste;
    }

    public function addGenreArtiste(Artiste $genreArtiste): self
    {
        if (!$this->genreArtiste->contains($genreArtiste)) {
            $this->genreArtiste->add($genreArtiste);
            $genreArtiste->setType($this);
        }

        return $this;
    }

    public function removeGenreArtiste(Artiste $genreArtiste): self
    {
        if ($this->genreArtiste->removeElement($genreArtiste)) {
            // set the owning side to null (unless already changed)
            if ($genreArtiste->getType() === $this) {
                $genreArtiste->setType(null);
            }
        }

        return $this;
    }
}
