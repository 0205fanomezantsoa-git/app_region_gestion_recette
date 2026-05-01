<?php

namespace App\Entity;

use App\Repository\CarnetQuittanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarnetQuittanceRepository::class)]
class CarnetQuittance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $idCarnet = null;

    #[ORM\Column]
    private ?int $nbFeuille = null;

    #[ORM\Column]
    private ?int $nbQuittance = null;

    #[ORM\Column(length: 20)]
    private ?string $numDebut = null;

    #[ORM\Column(length: 20)]
    private ?string $numFin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateAttribution = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'carnetQuittances')]
    private ?Agent $agent = null;

    /**
     * @var Collection<int, Quittance>
     */
    #[ORM\OneToMany(targetEntity: Quittance::class, mappedBy: 'carnetQuittance')]
    private Collection $quittances;

    public function __construct()
    {
        $this->quittances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCarnet(): ?string
    {
        return $this->idCarnet;
    }

    public function setIdCarnet(string $idCarnet): static
    {
        $this->idCarnet = $idCarnet;

        return $this;
    }

    public function getNbFeuille(): ?int
    {
        return $this->nbFeuille;
    }

    public function setNbFeuille(int $nbFeuille): static
    {
        $this->nbFeuille = $nbFeuille;

        return $this;
    }

    public function getNbQuittance(): ?int
    {
        return $this->nbQuittance;
    }

    public function setNbQuittance(int $nbQuittance): static
    {
        $this->nbQuittance = $nbQuittance;

        return $this;
    }

    public function getNumDebut(): ?string
    {
        return $this->numDebut;
    }

    public function setNumDebut(string $num_debut): static
    {
        $this->numDebut = $num_debut;

        return $this;
    }

    public function getNumFin(): ?string
    {
        return $this->numFin;
    }

    public function setNumFin(string $numFin): static
    {
        $this->numFin = $numFin;

        return $this;
    }

    public function getDateAttribution(): ?\DateTime
    {
        return $this->dateAttribution;
    }

    public function setDateAttribution(\DateTime $dateAttribution): static
    {
        $this->dateAttribution = $dateAttribution;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection<int, Quittance>
     */
    public function getQuittances(): Collection
    {
        return $this->quittances;
    }

    public function addQuittance(Quittance $quittance): static
    {
        if (!$this->quittances->contains($quittance)) {
            $this->quittances->add($quittance);
            $quittance->setCarnetQuittance($this);
        }

        return $this;
    }

    public function removeQuittance(Quittance $quittance): static
    {
        if ($this->quittances->removeElement($quittance)) {
            // set the owning side to null (unless already changed)
            if ($quittance->getCarnetQuittance() === $this) {
                $quittance->setCarnetQuittance(null);
            }
        }

        return $this;
    }
}
