<?php

namespace App\Entity;

use App\Repository\LigneVersementRegisseurVersTresorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneVersementRegisseurVersTresorRepository::class)]
class LigneVersementRegisseurVersTresor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVersementRegisseurVersTresors')]
    private ?Regisseur $regisseur = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVersementRegisseurVersTresors')]
    private ?Tresor $tresor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getRegisseur(): ?Regisseur
    {
        return $this->regisseur;
    }

    public function setRegisseur(?Regisseur $regisseur): static
    {
        $this->regisseur = $regisseur;

        return $this;
    }

    public function getTresor(): ?Tresor
    {
        return $this->tresor;
    }

    public function setTresor(?Tresor $tresor): static
    {
        $this->tresor = $tresor;

        return $this;
    }
}
