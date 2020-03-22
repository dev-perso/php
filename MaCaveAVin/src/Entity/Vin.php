<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VinsRepository")
 */
class Vin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Cave", mappedBy="id_vin")
     * @ORM\JoinColumn(name="id_vin", referencedColumnName="id_vin")
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Couleur", inversedBy="id_couleur")
     * @ORM\JoinColumn(name="id_couleur", referencedColumnName="id_couleur", nullable=false)
     */
    private $id_couleur;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Domaine", inversedBy="id_domaine")
     * @ORM\JoinColumn(name="id_domaine", referencedColumnName="id_domaine", nullable=true)
     */
    private $id_domaine;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Region", inversedBy="id_region")
     * @ORM\JoinColumn(name="id_region", referencedColumnName="id_region", nullable=false)
     */
    private $id_region;

    public function getId_Vin(): ?int
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

    public function setIdCouleur(?Couleur $id_couleur): self
    {
        $this->id_couleur = $id_couleur->getIdCouleur();

        return $this;
    }

    public function getIdDomaine(): ?int
    {
        return $this->id_domaine;
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

    public function setIdRegion(?Region $id_region): self
    {
        $this->id_region = $id_region->getIdRegion();

        return $this;
    }
}
