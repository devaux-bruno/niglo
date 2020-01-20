<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 */
class Service extends AbstractController
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="titre",type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\Column(name="description",type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="publier",type="string", length=60)
     */
    private $publier;

    /**
     * @return mixed
     */
    public function getPublier()
    {
        return $this->publier;
    }

    /**
     * @param mixed $publier
     * @return Service
     */
    public function setPublier($publier)
    {
        $this->publier = $publier;
        return $this;
    }

    /**
     * @ORM\Column(name="date_creation",type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="idService")
     */
    private $ServiceArticle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="idUtilisateurService")
     */
    private $ServiceUtilisateur;

    /**
     * @return mixed
     */
    public function getServiceUtilisateur()
    {
        return $this->ServiceUtilisateur;
    }

    /**
     * @param mixed $ServiceUtilisateur
     * @return Service
     */
    public function setServiceUtilisateur($ServiceUtilisateur)
    {
        $this->ServiceUtilisateur = $ServiceUtilisateur;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getServiceArticle(): ?Articles
    {
        return $this->ServiceArticle;
    }

    public function setServiceArticle(?Articles $ServiceArticle): self
    {
        $this->ServiceArticle = $ServiceArticle;

        return $this;
    }
}
