<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\ManyToOne(targetEntity: Adminstrateur::class, inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Adminstrateur $users = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $prix_unitaire = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]  # Relation ManyToOne
    #[ORM\JoinColumn(nullable: false)]  # Clé étrangère obligatoire
    private ?Categorie $categorie = null;


    #[ORM\Column(type: 'string', length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 500)]
    private ?string $labelle = null;

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

    public function getUsers(): ?Adminstrateur
    {
        return $this->users;
    }

    public function setUsers(?Adminstrateur $users): static
    {
        $this->users = $users;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(string $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(Categorie $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getLabelle(): ?string
    {
        return $this->labelle;
    }

    public function setLabelle(?string $Labelle): static
    {
        $this->labelle = $Labelle;
        return $this;
    }

}
