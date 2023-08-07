<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
#[ApiResource]
//Contrainte pour éviter doublons des noms de produits
// #[UniqueEntity(['nom_produit'], 'Ce nom de produit est indisponible !')]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    //Contrainte sur le nbre de caractères min et max du nom du produit
    //min 2 caractères max 50 
    // la méthode limit est dans le fichier vendor->symfony->contraints->validator->Length.php
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom de votre produit doit être au moins de {{ limit }} caractères',
        maxMessage: 'Le nom de votre produit doit ne peut pas excéder {{ limit }} caractères',
    )]
    private ?string $nom_produit = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description_produit = null;

    #[ORM\Column(length: 255)]
    private ?string $image_produit = null;

    #[ORM\Column]
    private ?bool $stock_produit = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_depot_produit = null;

    #[ORM\Column]
    //Contrainte pour interdir des chiffres négatifs pour les prix_produits 
    #[Assert\Positive]
    private ?int $prix_produit = null;
    //! ONE TO ONE avec References
    #[ORM\OneToOne(inversedBy: 'nom_ref_produit', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?References $reference = null;
    
    //! MANY TO MANY  MANY Produits to MANY Enseignes
    #[ORM\ManyToMany(targetEntity: Enseignes::class, inversedBy: 'produits')]
    private Collection $enseignes;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    //! MANY TO ONE  MANY ProduitS TO ONE Users
    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $user = null;

    public function __construct()
    {
        $this->enseignes = new ArrayCollection();
    }
    // todo la propriete de class $reference sera a appellé dans  pour appeller la methode getNumeroReference() methode de la class References.php

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDescriptionProduit(): ?string
    {
        return $this->description_produit;
    }

    public function setDescriptionProduit(string $description_produit): static
    {
        $this->description_produit = $description_produit;

        return $this;
    }

    public function getImageProduit(): ?string
    {
        return $this->image_produit;
    }

    public function setImageProduit(string $image_produit): static
    {
        $this->image_produit = $image_produit;

        return $this;
    }

    public function isStockProduit(): ?bool
    {
        return $this->stock_produit;
    }

    public function setStockProduit(bool $stock_produit): static
    {
        $this->stock_produit = $stock_produit;

        return $this;
    }

    public function getDateDepotProduit(): ?\DateTimeInterface
    {
        return $this->date_depot_produit;
    }

    public function setDateDepotProduit(\DateTimeInterface $date_depot_produit): static
    {
        $this->date_depot_produit = $date_depot_produit;

        return $this;
    }

    public function getPrixProduit(): ?int
    {
        return $this->prix_produit;
    }

    public function setPrixProduit(int $prix_produit): static
    {
        $this->prix_produit = $prix_produit;

        return $this;
    }

    public function getReference(): ?References
    {
        return $this->reference;
    }

    public function setReference(References $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection<int, Enseignes>
     */
    public function getEnseignes(): Collection
    {
        return $this->enseignes;
    }

    public function addEnseigne(Enseignes $enseigne): static
    {
        if (!$this->enseignes->contains($enseigne)) {
            $this->enseignes->add($enseigne);
        }

        return $this;
    }

    public function removeEnseigne(Enseignes $enseigne): static
    {
        $this->enseignes->removeElement($enseigne);

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): static
    {
        $this->user = $user;

        return $this;
    }
}
