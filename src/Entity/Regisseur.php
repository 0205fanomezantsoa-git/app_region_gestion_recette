<?php

namespace App\Entity;

use App\Repository\RegisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegisseurRepository::class)]
class Regisseur
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
     * @var Collection<int, Agent>
     */
    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'regisseur')]
    private Collection $agents;

    /**
     * @var Collection<int, LigneVersementAgentVersRegisseur>
     */
    #[ORM\OneToMany(targetEntity: LigneVersementAgentVersRegisseur::class, mappedBy: 'regisseur')]
    private Collection $ligneVersementAgentVersRegisseurs;

    #[ORM\ManyToOne(inversedBy: 'regisseurs')]
    private ?Tresor $tresor = null;

    /**
     * @var Collection<int, LigneVersementRegisseurVersTresor>
     */
    #[ORM\OneToMany(targetEntity: LigneVersementRegisseurVersTresor::class, mappedBy: 'regisseur')]
    private Collection $ligneVersementRegisseurVersTresors;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
        $this->ligneVersementAgentVersRegisseurs = new ArrayCollection();
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
     * @return Collection<int, Agent>
     */
    public function getAgent(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): static
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->setRegisseur($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): static
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getRegisseur() === $this) {
                $agent->setRegisseur(null);
            }
        }

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
            $ligneVersementAgentVersRegisseur->setRegisseur($this);
        }

        return $this;
    }

    public function removeLigneVersementAgentVersRegisseur(LigneVersementAgentVersRegisseur $ligneVersementAgentVersRegisseur): static
    {
        if ($this->ligneVersementAgentVersRegisseurs->removeElement($ligneVersementAgentVersRegisseur)) {
            // set the owning side to null (unless already changed)
            if ($ligneVersementAgentVersRegisseur->getRegisseur() === $this) {
                $ligneVersementAgentVersRegisseur->setRegisseur(null);
            }
        }

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
            $ligneVersementRegisseurVersTresor->setRegisseur($this);
        }

        return $this;
    }

    public function removeLigneVersementRegisseurVersTresor(LigneVersementRegisseurVersTresor $ligneVersementRegisseurVersTresor): static
    {
        if ($this->ligneVersementRegisseurVersTresors->removeElement($ligneVersementRegisseurVersTresor)) {
            // set the owning side to null (unless already changed)
            if ($ligneVersementRegisseurVersTresor->getRegisseur() === $this) {
                $ligneVersementRegisseurVersTresor->setRegisseur(null);
            }
        }

        return $this;
    }
}
