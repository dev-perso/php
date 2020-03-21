<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CouleurRepository")
 */
class Couleur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Vin", mappedBy="id_couleur")
     * @ORM\JoinColumn(name="id_couleur", referencedColumnName="id_couleur")
     */
    private $id_couleur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    public function getIdCouleur(): ?int
    {
        return $this->id_couleur;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }
}
