<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_depart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_retour = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Voiture $Voiture = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Client $Client = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Agence $Agence = null;

    public function calculerDuree(\DateTimeInterface $date_depart ,\DateTimeInterface $date_retour): ?int
    {
        $interval = $date_depart->diff($date_retour);
        return $interval->days;

    }
    public function getPrix()
    {
        return $this->getVoiture()->getPrixLocation();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdate_depart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    public function setDateDepart(\DateTimeInterface $date_depart): static
    {
        $this->date_depart = $date_depart;

        return $this;
    }

    public function getdate_retour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    public function setDateRetour(\DateTimeInterface $date_retour): static
    {
        $this->date_retour = $date_retour;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->Voiture;
    }

    public function setVoiture(?Voiture $Voiture): static
    {
        $this->Voiture = $Voiture;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): static
    {
        $this->Client = $Client;

        return $this;
    }

    public function getAgence(): ?Agence
    {
        return $this->Agence;
    }

    public function setAgence(?Agence $Agence): static
    {
        $this->Agence = $Agence;

        return $this;
    }

    /**
     * Get the value of date_depart
     */
    public function getDateDepart(): ?\DateTimeInterface
    {
        return $this->date_depart;
    }

    /**
     * Get the value of date_retour
     */
    public function getDateRetour(): ?\DateTimeInterface
    {
        return $this->date_retour;
    }

    
   
}
