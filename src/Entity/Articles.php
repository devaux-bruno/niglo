<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */
class Articles extends AbstractController
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="titre",type="string", length=60)
     */
    private $titre;

    /**
     * @ORM\Column(name="description_courte",type="string", length=255)
     */
    private $descriptionCourte;

    /**
     * @ORM\Column(name="texte",type="text")
     */
    private $texte;

    /**
     * @ORM\Column(name="image_principale",type="string", length=255, nullable=true)
     */
    private $imagePrincipale;


    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="UtilisateurArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_user_id" , referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="ServiceArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $idService;


    /**
     * @ORM\Column(name="date_publication",type="datetime")
     */
    private $datePublication;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaires", inversedBy="idArticle")
     * @ORM\JoinColumn(nullable=true)
     */
    private $ArticlesCommentaires;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescriptionCourte(): ?string
    {
        return $this->descriptionCourte;
    }

    public function setDescriptionCourte(string $descriptionCourte): self
    {
        $this->descriptionCourte = $descriptionCourte;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getImagePrincipale()
    {
        return $this->imagePrincipale;
    }

    public function setImagePrincipale(?string $imagePrincipale)
    {
        $this->imagePrincipale = $imagePrincipale;

        return $this;
    }

    /**
     * @return Service
     */
    public function getIdService()
    {
        return $this->idService;
    }

    public function setIdService(?Service $idService): self
    {
        $this->idService = $idService;

        return $this;
    }


    /**
     * @return Utilisateur
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): self
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    public function getArticlesCommentaires(): ?Commentaires
    {
        return $this->ArticlesCommentaires;
    }

    public function setArticlesCommentaires(?Commentaires $ArticlesCommentaires): self
    {
        $this->ArticlesCommentaires = $ArticlesCommentaires;

        return $this;
    }
}
