<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le nom de votre produit')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Le nom de votre produit doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'Le nom de votre produit ne peut pas dépasser {{ limit }} caractères, le votre en contient {{ value_length }}.'
    )]
    private ?string $productName = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la description de votre produit')]
    private ?string $productDescription = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^[1-9]\d*$/',
        message: 'L\'heure doit contenir uniquement des chiffres positifs',
        match: true,
    )]
    private ?int $productHour = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^[1-9]\d*$/',
        message: 'Le prix doit contenir uniquement des chiffres positifs',
        match: true,
    )]
    private ?int $productPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $validityDate = null;

    public function __construct()
    {
        $current_date = new \DateTime();
        $this->created_at = new \DateTimeImmutable();
        $this->updated_at = new \DateTimeImmutable();
        $this->validityDate = new \DateTimeImmutable($current_date->modify('+1 month')->format('Y-m-d H:i:s'));
    }

    public function __toString()
    {
        return $this->productName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(string $productDescription): static
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductHour(): ?int
    {
        return $this->productHour;
    }

    public function setProductHour(int $productHour): static
    {
        $this->productHour = $productHour;

        return $this;
    }

    public function getProductPrice(): ?int
    {
        return $this->productPrice;
    }

    public function setProductPrice(int $productPrice): static
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getValidityDate(): ?\DateTimeImmutable
    {
        return $this->validityDate;
    }

    public function setValidityDate(\DateTimeImmutable $validityDate): static
    {
        $this->validityDate = $validityDate;

        return $this;
    }

}
