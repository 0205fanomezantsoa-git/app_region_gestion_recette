<?php

namespace App\Entity;

use App\Repository\DistrictRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistrictRepository::class)]
class District
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Localite>
     */
    #[ORM\OneToMany(targetEntity: Localite::class, mappedBy: 'district')]
    private Collection $localites;

    public function __construct()
    {
        $this->localites = new ArrayCollection();
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
     * @return Collection<int, Localite>
     */
    public function getLocalites(): Collection
    {
        return $this->localites;
    }

    public function addLocalite(Localite $localite): static
    {
        if (!$this->localites->contains($localite)) {
            $this->localites->add($localite);
            $localite->setDistrict($this);
        }

        return $this;
    }

    public function removeLocalite(Localite $localite): static
    {
        if ($this->localites->removeElement($localite)) {
            // set the owning side to null (unless already changed)
            if ($localite->getDistrict() === $this) {
                $localite->setDistrict(null);
            }
        }

        return $this;
    }
}
