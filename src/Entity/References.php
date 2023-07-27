<?php

namespace App\Entity;

use App\Repository\ReferencesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferencesRepository::class)]
#[ORM\Table(name: '`references`')]
class References
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_reference = null;

    //! ONE TO ONE avec Produits
    #[ORM\OneToOne(mappedBy: 'reference', cascade: ['persist', 'remove'])]
    private ?Produits $nom_ref_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroReference(): ?int
    {
        return $this->numero_reference;
    }

    public function setNumeroReference(int $numero_reference): static
    {
        $this->numero_reference = $numero_reference;

        return $this;
    }

    public function getNomRefProduit(): ?Produits
    {
        return $this->nom_ref_produit;
    }

    public function setNomRefProduit(Produits $nom_ref_produit): static
    {
        // set the owning side of the relation if necessary
        if ($nom_ref_produit->getReference() !== $this) {
            $nom_ref_produit->setReference($this);
        }

        $this->nom_ref_produit = $nom_ref_produit;

        return $this;
    }
}
