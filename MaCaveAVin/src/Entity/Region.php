<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Vin", mappedBy="id_region")
     * @ORM\JoinColumn(name="id_region", referencedColumnName="id_region")
     */
    private $id_region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Pays", inversedBy="id_pays")
     * @ORM\JoinColumn(name="id_pays", referencedColumnName="id_pays", nullable=false)
     */
    private $id_pays;

    public function getIdRegion(): ?int
    {
        return $this->id_region;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getId_Pays(): ?Pays
    {
        return $this->id_pays;
    }

    public function setIdPays(?Pays $id_pays): self
    {
        $this->id_pays = $id_pays;

        return $this;
    }
}
