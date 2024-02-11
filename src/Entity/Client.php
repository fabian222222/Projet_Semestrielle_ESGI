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
    #[Assert\NotBlank(message: 'Veuillez renseigner votre prénom')]
    #[Assert\Length(
        min: 2,
        max: 30,
        minMessage: 'Votre prénom doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'Votre prénom ne peut pas dépasser {{ limit }} caractères, le votre en contient {{ value_length }}.'
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner votre nom')]
    #[Assert\Length(
        min: 2,
        max: 60,
        minMessage: 'Votre nom doit contenir au moins {{ limit }} caractères, le votre en contient {{ value_length }}.',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères, le votre en contient {{ value_length }}.'
    )]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(
        message: 'Votre mail {{ value }} n\'est pas valide',
    )]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'clients')]
    #[ORM\JoinColumn(nullable: false)]
    private ?DrivingSchool $drivingSchool = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Invoice::class)]
    private Collection $invoices;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->firstname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

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
}
