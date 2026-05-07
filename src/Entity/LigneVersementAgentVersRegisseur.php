<?php

namespace App\Entity;

use App\Repository\LigneVersementAgentVersRegisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LigneVersementAgentVersRegisseurRepository::class)]
class LigneVersementAgentVersRegisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(length: 50)]
    private ?string $typeVersement = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVersementAgentVersRegisseurs')]
    private ?Agent $agent = null;

    #[ORM\ManyToOne(inversedBy: 'ligneVersementAgentVersRegisseurs')]
    private ?Regisseur $regisseur = null;

    /**
     * @var Collection<int, Quittance>
     */
    #[ORM\OneToMany(targetEntity: Quittance::class, mappedBy: 'versement')]
    private Collection $quittances;

    public function __construct()
    {
        $this->quittances = new ArrayCollection();
    }

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

    public function getTypeVersement(): ?string
    {
        return $this->typeVersement;
    }

    public function setTypeVersement(string $typeVersement): static
    {
        $this->typeVersement = $typeVersement;

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

    public function getRegisseur(): ?Regisseur
    {
        return $this->regisseur;
    }

    public function setRegisseur(?Regisseur $regisseur): static
    {
        $this->regisseur = $regisseur;

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
            $quittance->setVersement($this);
        }

        return $this;
    }

    public function removeQuittance(Quittance $quittance): static
    {
        if ($this->quittances->removeElement($quittance)) {
            // set the owning side to null (unless already changed)
            if ($quittance->getVersement() === $this) {
                $quittance->setVersement(null);
            }
        }

        return $this;
    }
}
