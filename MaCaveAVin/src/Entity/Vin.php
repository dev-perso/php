<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VinsRepository")
 */
class Vin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_vin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appellation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_couleur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Couleur")
     * @ORM\JoinColumn(name="id_couleur", referencedColumnName="id_couleur", nullable=false)
     */
    private $couleur;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_domaine;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Domaine")
     * @ORM\JoinColumn(name="id_domaine", referencedColumnName="id_domaine", nullable=true)
     */
    private $domaine;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_region;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Region")
     * @ORM\JoinColumn(name="id_region", referencedColumnName="id_region", nullable=false)
     */
    private $region;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User")
     * @JoinTable(name="cave",
     *      joinColumns={@JoinColumn(name="id_vin", referencedColumnName="id_vin")},
     *      inverseJoinColumns={@JoinColumn(name="id_user", referencedColumnName="id_user")})
     */
    private $users;

    /**
     * int
     */
    private $quantity;

    /**
     * @ORM\Column(type="integer")
     */
    private $annee;

    public function __construct()
    {
        //$this->users = new \Doctrine\Common\Collections\PersistentCollection();
    }

    public function getIdVin(): ?int
    {
        return $this->id_vin;
    }

    public function getAppellation(): ?string
    {
        return $this->appellation;
    }

    public function setAppellation(string $appellation): self
    {
        $this->appellation = $appellation;

        return $this;
    }    

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdCouleur(): ?int
    {
        return $this->id_couleur;
    }

    public function getEntityCouleur(): ?Couleur
    {
        return $this->couleur;
    }

    public function setIdCouleur(?Couleur $id_couleur): self
    {
        $this->id_couleur = $id_couleur->getIdCouleur();

        return $this;
    }

    public function getIdDomaine(): ?int
    {
        return $this->id_domaine;
    }

    public function getEntityDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setIdDomaine(?Domaine $id_domaine): self
    {
        $this->id_domaine = $id_domaine->getIdDomaine();

        return $this;
    }

    public function getIdRegion(): ?int
    {
        return $this->id_region;
    }

    public function getEntityRegion(): ?Region
    {
        return $this->region;
    }

    public function setIdRegion(?Region $id_region): self
    {
        $this->id_region = $id_region->getIdRegion();

        return $this;
    }

    public function getUsers(): ?PersistentCollection
    {
        return $this->users;
    }

    public function setUsers(?PersistentCollection $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
