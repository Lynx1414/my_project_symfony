<?php

namespace App\Entity;

use App\Repository\EnseignesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignesRepository::class)]
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
}
