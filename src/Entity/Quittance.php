<?php

namespace App\Entity;

use App\Repository\QuittanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuittanceRepository::class)]
class Quittance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $numQuittance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateUtilisation = null;

    #[ORM\Column(length: 255)]
    private ?string $nomClient = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $montantTotal = null;

    #[ORM\ManyToOne(inversedBy: 'quittances')]
    private ?CarnetQuittance $carnetQuittance = null;

    #[ORM\ManyToOne(inversedBy: 'quittance')]
    private ?Produit $produit = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'quittances')]
    private ?LigneVersementAgentVersRegisseur $versement = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumQuittance(): ?string
    {
        return $this->numQuittance;
    }

    public function setNumQuittance(string $numQuittance): static
    {
        $this->numQuittance = $numQuittance;

        return $this;
    }

    public function getDateUtilisation(): ?\DateTime
    {
        return $this->dateUtilisation;
    }

    public function setDateUtilisation(\DateTime $dateUtilisation): static
    {
        $this->dateUtilisation = $dateUtilisation;

        return $this;
    }

    public function getNomClient(): ?string
    {
        return $this->nomClient;
    }

    public function setNomClient(string $nomClient): static
    {
        $this->nomClient = $nomClient;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montantTotal;
    }

    public function setMontantTotal(float $montantTotal): static
    {
        $this->montantTotal = $montantTotal;

        return $this;
    }

    public function getCarnetQuittance(): ?CarnetQuittance
    {
        return $this->carnetQuittance;
    }

    public function setCarnetQuittance(?CarnetQuittance $carnetQuittance): static
    {
        $this->carnetQuittance = $carnetQuittance;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getVersement(): ?LigneVersementAgentVersRegisseur
    {
        return $this->versement;
    }

    public function setVersement(?LigneVersementAgentVersRegisseur $versement): static
    {
        $this->versement = $versement;

        return $this;
    }
}
