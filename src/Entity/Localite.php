<?php

namespace App\Entity;

use App\Repository\LocaliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocaliteRepository::class)]
class Localite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'localites')]
    private ?District $district = null;

    /**
     * @var Collection<int, Agent>
     */
    #[ORM\OneToMany(targetEntity: Agent::class, mappedBy: 'localite')]
    private Collection $agents;

    #[ORM\ManyToOne]
    private ?Regisseur $regisseurs = null;

    #[ORM\ManyToOne]
    private ?Tresor $tresor = null;

    public function __construct()
    {
        $this->agents = new ArrayCollection();
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

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): static
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    public function addAgent(Agent $agent): static
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
            $agent->setLocalite($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): static
    {
        if ($this->agents->removeElement($agent)) {
            // set the owning side to null (unless already changed)
            if ($agent->getLocalite() === $this) {
                $agent->setLocalite(null);
            }
        }

        return $this;
    }

    public function getRegisseurs(): ?Regisseur
    {
        return $this->regisseurs;
    }

    public function setRegisseurs(?Regisseur $regisseurs): static
    {
        $this->regisseurs = $regisseurs;

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
