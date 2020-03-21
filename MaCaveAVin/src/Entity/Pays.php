<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaysRepository")
 */
class Pays
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Region", mappedBy="id_pays")
     * @ORM\JoinColumn(name="id_pays", referencedColumnName="id_pays")
     */
    private $id_pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    public function getId_Pays(): ?int
    {
        return $this->id_pays;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
