<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 25)]
    private ?string $telephone = null;

    #[ORM\Column]
    private ?float $portefeuille = null;

    /**
     * @var Collection<int, CarnetQuittance>
     */
    #[ORM\OneToMany(targetEntity: CarnetQuittance::class, mappedBy: 'agent')]
    private Collection $carnetQuittances;

    #[ORM\ManyToOne(inversedBy: 'agent')]
    private ?Regisseur $regisseur = null;

    /**
     * @var Collection<int, LigneVersementAgentVersRegisseur>
     */
    #[ORM\OneToMany(targetEntity: LigneVersementAgentVersRegisseur::class, mappedBy: 'agent')]
    private Collection $ligneVersementAgentVersRegisseurs;

    #[ORM\ManyToOne(inversedBy: 'agents')]
    private ?Localite $localite = null;

    public function __construct()
    {
        $this->carnetQuittances = new ArrayCollection();
        $this->ligneVersementAgentVersRegisseurs = new ArrayCollection();
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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
     * @return Collection<int, CarnetQuittance>
     */
    public function getCarnetQuittances(): Collection
    {
        return $this->carnetQuittances;
    }

    public function addCarnetQuittance(CarnetQuittance $carnetQuittance): static
    {
        if (!$this->carnetQuittances->contains($carnetQuittance)) {
            $this->carnetQuittances->add($carnetQuittance);
            $carnetQuittance->setAgent($this);
        }

        return $this;
    }

    public function removeCarnetQuittance(CarnetQuittance $carnetQuittance): static
    {
        if ($this->carnetQuittances->removeElement($carnetQuittance)) {
            // set the owning side to null (unless already changed)
            if ($carnetQuittance->getAgent() === $this) {
                $carnetQuittance->setAgent(null);
            }
        }

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
     * @return Collection<int, LigneVersementAgentVersRegisseur>
     */
    public function getLigneVersementAgentVersRegisseurs(): Collection
    {
        return $this->ligneVersementAgentVersRegisseurs;
    }

    public function addLigneVersementAgentVersRegisseur(LigneVersementAgentVersRegisseur $ligneVersementAgentVersRegisseur): static
    {
        if (!$this->ligneVersementAgentVersRegisseurs->contains($ligneVersementAgentVersRegisseur)) {
            $this->ligneVersementAgentVersRegisseurs->add($ligneVersementAgentVersRegisseur);
            $ligneVersementAgentVersRegisseur->setAgent($this);
        }

        return $this;
    }

    public function removeLigneVersementAgentVersRegisseur(LigneVersementAgentVersRegisseur $ligneVersementAgentVersRegisseur): static
    {
        if ($this->ligneVersementAgentVersRegisseurs->removeElement($ligneVersementAgentVersRegisseur)) {
            // set the owning side to null (unless already changed)
            if ($ligneVersementAgentVersRegisseur->getAgent() === $this) {
                $ligneVersementAgentVersRegisseur->setAgent(null);
            }
        }

        return $this;
    }

    public function getLocalite(): ?Localite
    {
        return $this->localite;
    }

    public function setLocalite(?Localite $localite): static
    {
        $this->localite = $localite;

        return $this;
    }
}
