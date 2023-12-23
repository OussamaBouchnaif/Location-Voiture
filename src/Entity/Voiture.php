<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_achat = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $km_compteur = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $charge_max = null;

    #[ORM\Column]
    private ?float $prix_location = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Model $Model = null;

    #[ORM\ManyToOne(inversedBy: 'voitures')]
    private ?Categorie $Categorie = null;

    #[ORM\OneToMany(mappedBy: 'Voiture', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getdate_achat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    public function setDateAchat(?\DateTimeInterface $date_achat): static
    {
        $this->date_achat = $date_achat;

        return $this;
    }

    public function getKm_compteur(): ?int
    {
        return $this->km_compteur;
    }

    public function setKmCompteur(int $km_compteur): static
    {
        $this->km_compteur = $km_compteur;

        return $this;
    }

    public function getcharge_max(): ?int
    {
        return $this->charge_max;
    }

    public function setChargeMax(int $charge_max): static
    {
        $this->charge_max = $charge_max;

        return $this;
    }

    public function getprix_location(): ?float
    {
        return $this->prix_location;
    }

    public function setPrixLocation(float $prix_location): static
    {
        $this->prix_location = $prix_location;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->Model;
    }

    public function setModel(?Model $Model): static
    {
        $this->Model = $Model;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setVoiture($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getVoiture() === $this) {
                $reservation->setVoiture(null);
            }
        }

        return $this;
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

    /**
     * Get the value of km_compteur
     */
    public function getKmCompteur(): ?int
    {
        return $this->km_compteur;
    }

    /**
     * Get the value of charge_max
     */
    public function getChargeMax(): ?int
    {
        return $this->charge_max;
    }

    /**
     * Get the value of date_achat
     */
    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->date_achat;
    }

    /**
     * Get the value of prix_location
     */
    public function getPrixLocation(): ?float
    {
        return $this->prix_location;
    }
    public function __toString()
    {
        return $this->getModel()->getLibelle().'-'.$this->getCategorie()->getLibelle();
    }
    
}
