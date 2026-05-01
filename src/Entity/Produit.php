<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomProduit = null;

    #[ORM\Column(length: 20)]
    private ?string $uniteMesure = null;

    #[ORM\Column]
    private ?float $ristourne = null;

    /**
     * @var Collection<int, Quittance>
     */
    #[ORM\OneToMany(targetEntity: Quittance::class, mappedBy: 'produit')]
    private Collection $quittance;

    public function __construct()
    {
        $this->quittance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(string $nomProduit): static
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getUniteMesure(): ?string
    {
        return $this->uniteMesure;
    }

    public function setUniteMesure(string $uniteMesure): static
    {
        $this->uniteMesure = $uniteMesure;

        return $this;
    }

    public function getRistourne(): ?float
    {
        return $this->ristourne;
    }

    public function setRistourne(float $ristourne): static
    {
        $this->ristourne = $ristourne;

        return $this;
    }

    /**
     * @return Collection<int, Quittance>
     */
    public function getQuittance(): Collection
    {
        return $this->quittance;
    }

    public function addQuittance(Quittance $quittance): static
    {
        if (!$this->quittance->contains($quittance)) {
            $this->quittance->add($quittance);
            $quittance->setProduit($this);
        }

        return $this;
    }

    public function removeQuittance(Quittance $quittance): static
    {
        if ($this->quittance->removeElement($quittance)) {
            // set the owning side to null (unless already changed)
            if ($quittance->getProduit() === $this) {
                $quittance->setProduit(null);
            }
        }

        return $this;
    }
}
