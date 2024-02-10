<?php

namespace App\Entity;

use App\Entity\Invoice;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DrivingSchool $drivingSchool = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Invoice::class)]
    private Collection $invoices;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner l\'adresse de votre client')]
    #[Assert\Length(
        min: 10,
        max: 80,
        minMessage: 'L\'adresse de votre client doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'L\'adresse de votre client ne peut pas dépasser {{ limit }} caractères, le votre en contient {{ value_length }}.'
    )]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la ville de votre client')]
    #[Assert\Length(
        min: 4,
        max: 50,
        minMessage: 'La ville de votre client doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'La ville de votre client ne peut pas dépasser {{ limit }} caractères, le votre en contient {{ value_length }}.'
    )]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez renseigner un code postal')]
    #[Assert\Length(
        min: 5,
        minMessage: 'Le code postal du client doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
    )]
    #[Assert\Positive]
    private ?int $zipCode = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\NotBlank(message: 'Veuillez renseigner un numéro de voie')]
    #[Assert\Length(
        min: 1,
        max: 3,
        minMessage: 'Le numéro de voie du client doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'Le numéro de voie du client doit contenir maximum {{ limit }} caractères, le votre en contient {{ value_length }}.',
    )]
    private ?int $Number = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^\d+$/',
        message: 'Votre numéro de téléphone ne peut contenir que des chiffres',
        match: true,
    )]
    #[Assert\NotBlank(message: 'Veuillez renseigner un numéro de téléphone')]
    #[Assert\Length(
        min: 10,
        minMessage: 'Le numéro de téléphone du client doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
    )]
    private ?string $phoneNumber = null;


    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setClient($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getClient() === $this) {
                $contract->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setClient($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getClient() === $this) {
                $invoice->setClient(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->Number;
    }

    public function setNumber(int $Number): static
    {
        $this->Number = $Number;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
