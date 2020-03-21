<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DomaineRepository")
 */
class Domaine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Vin", mappedBy="id_domaine")
     * @ORM\JoinColumn(name="id_domaine", referencedColumnName="id_domaine")
     */
    private $id_domaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;

    public function getIdDomaine(): ?int
    {
        return $this->id_domaine;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }
}
