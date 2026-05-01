<?php

namespace App\Entity;

use App\Repository\TresorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TresorRepository::class)]
class Tresor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $portefeuille = null;

    /**
     * @var Collection<int, Regisseur>
     */
    #[ORM\OneToMany(targetEntity: Regisseur::class, mappedBy: 'tresor')]
    private Collection $regisseurs;

    /**
     * @var Collection<int, LigneVersementRegisseurVersTresor>
     */
    #[ORM\OneToMany(targetEntity: LigneVersementRegisseurVersTresor::class, mappedBy: 'tresor')]
    private Collection $ligneVersementRegisseurVersTresors;

    public function __construct()
    {
        $this->regisseurs = new ArrayCollection();
        $this->ligneVersementRegisseurVersTresors = new ArrayCollection();
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

    public function getPortefeuille(): ?float
    {
        return $this->portefeuille;
    }

    public function setPortefeuille(float $portefeuille): static
    {
        $this->portefeuille = $portefeuille;

        return $this;
    }

    /**
     * @return Collection<int, Regisseur>
     */
    public function getRegisseurs(): Collection
    {
        return $this->regisseurs;
    }

    public function addRegisseur(Regisseur $regisseur): static
    {
        if (!$this->regisseurs->contains($regisseur)) {
            $this->regisseurs->add($regisseur);
            $regisseur->setTresor($this);
        }

        return $this;
    }

    public function removeRegisseur(Regisseur $regisseur): static
    {
        if ($this->regisseurs->removeElement($regisseur)) {
            // set the owning side to null (unless already changed)
            if ($regisseur->getTresor() === $this) {
                $regisseur->setTresor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LigneVersementRegisseurVersTresor>
     */
    public function getLigneVersementRegisseurVersTresors(): Collection
    {
        return $this->ligneVersementRegisseurVersTresors;
    }

    public function addLigneVersementRegisseurVersTresor(LigneVersementRegisseurVersTresor $ligneVersementRegisseurVersTresor): static
    {
        if (!$this->ligneVersementRegisseurVersTresors->contains($ligneVersementRegisseurVersTresor)) {
            $this->ligneVersementRegisseurVersTresors->add($ligneVersementRegisseurVersTresor);
            $ligneVersementRegisseurVersTresor->setTresor($this);
        }

        return $this;
    }

    public function removeLigneVersementRegisseurVersTresor(LigneVersementRegisseurVersTresor $ligneVersementRegisseurVersTresor): static
    {
        if ($this->ligneVersementRegisseurVersTresors->removeElement($ligneVersementRegisseurVersTresor)) {
            // set the owning side to null (unless already changed)
            if ($ligneVersementRegisseurVersTresor->getTresor() === $this) {
                $ligneVersementRegisseurVersTresor->setTresor(null);
            }
        }

        return $this;
    }
}
