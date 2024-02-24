<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\Regex(
        pattern: '^[0-9]+(?:\.[0-9]+)?$',
        message: 'Le prix ne peut pas être négatif',
        match: true,
    )]
    private ?int $price = null;

    #[ORM\Column(type: Types::TEXT)]
//    #[Assert\NotBlank(message: 'Veuillez renseigner une description')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $validityDate = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DrivingSchool $drivingSchool = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getValidityDate(): ?\DateTimeInterface
    {
        return $this->validityDate;
    }

    public function setValidityDate(\DateTimeInterface $validityDate): static
    {
        $this->validityDate = $validityDate;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDrivingSchool(): ?DrivingSchool
    {
        return $this->drivingSchool;
    }

    public function setDrivingSchool(?DrivingSchool $drivingSchool): static
    {
        $this->drivingSchool = $drivingSchool;

        return $this;
    }
}
