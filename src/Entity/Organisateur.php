<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganisateurRepository")
 */
class Organisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="organisateurs")
     *  @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="utilisateur_id" , referencedColumnName="id")
     *  })
     */
    private $idUtilisateurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="ServiceOrganisateur")
     *  @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     *  })
     */
    private $idService;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAjout;

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getIdService()
    {
        return $this->idService;
    }

    /**
     * @param mixed $idService
     * @return Organisateur
     */
    public function setIdService($idService)
    {
        $this->idService = $idService;
        return $this;
    }


    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getIdUtilisateurs()
    {
        return $this->idUtilisateurs;
    }

    /**
     * @param mixed $idUtilisateurs
     * @return Organisateur
     */
    public function setIdUtilisateurs($idUtilisateurs)
    {
        $this->idUtilisateurs = $idUtilisateurs;
        return $this;
    }
}
