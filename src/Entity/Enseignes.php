<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EnseignesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignesRepository::class)]
#[ApiResource]
class Enseignes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_enseigne = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column]
    private ?int $nbre_employes = null;

    #[ORM\Column]
    private ?float $chiffre_affaire_annuel_HT = null;
    //! MANY TO MANY avec Produits
    #[ORM\ManyToMany(targetEntity: Produits::class, mappedBy: 'enseignes')]
    private Collection $produits;
    //tableau d'objet qui inclut un tableau en value json_encode

    public function __toString()
    {
        return $this->nom_enseigne;
    }

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnseigne(): ?string
    {
        return $this->nom_enseigne;
    }

    public function setNomEnseigne(string $nom_enseigne): static
    {
        $this->nom_enseigne = $nom_enseigne;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNbreEmployes(): ?int
    {
        return $this->nbre_employes;
    }

    public function setNbreEmployes(int $nbre_employes): static
    {
        $this->nbre_employes = $nbre_employes;

        return $this;
    }

    public function getChiffreAffaireAnnuelHT(): ?float
    {
        return $this->chiffre_affaire_annuel_HT;
    }

    public function setChiffreAffaireAnnuelHT(float $chiffre_affaire_annuel_HT): static
    {
        $this->chiffre_affaire_annuel_HT = $chiffre_affaire_annuel_HT;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->addEnseigne($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            $produit->removeEnseigne($this);
        }

        return $this;
    }
}
