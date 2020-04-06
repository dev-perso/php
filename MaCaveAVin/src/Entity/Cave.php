<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CaveRepository")
 */
class Cave
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_cave;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prix;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(name="archive", type="boolean", options={"default" : 0})
     */
    private $archive;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id_user", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_vin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vin")
     * @ORM\JoinColumn(name="id_vin", referencedColumnName="id_vin", nullable=false)
     */
    private $vin;

    public function __construct()
    {
        $this->archive = false;
    }

    public function getIdCave(): ?int
    {
        return $this->id_cave;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function getIdUser(): ?int
    {
        return $this->id_user;
    }

    public function getEntityUser(): ?User
    {
        return $this->user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user->getIdUser();

        return $this;
    }

    public function getIdVin(): ?int
    {
        return $this->id_vin;
    }

    public function getEntityVin(): ?Vin
    {
        return $this->vin;
    }

    public function setIdVin(?Vin $id_vin): self
    {
        $this->id_vin = $id_vin->getId_Vin();

        return $this;
    }
}
