<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @ORM\Table(name="commentaires")
 * @ORM\Entity(repositoryClass="App\Repository\CommentairesRepository")
 */
class Commentaires extends AbstractController
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="UtilisateurCommentaires")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id" , referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @var Articles
     *
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="ArticlesCommentaires")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="article_id" , referencedColumnName="id")
     * })
     */
    private $idArticle;

    /**
     * @ORM\Column(name="commentaire",type="text")
     */
    private $commentaire;

    /**
     * @ORM\Column(name="date_post",type="datetime")
     */
    private $datePost;

    /**
     * @ORM\Column(type="integer")
     */
    private $signaler;


    public function getId(): ?int
    {
        return $this->id;
    }



    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getDatePost(): ?\DateTimeInterface
    {
        return $this->datePost;
    }

    public function setDatePost(\DateTimeInterface $datePost): self
    {
        $this->datePost = $datePost;

        return $this;
    }

    public function getSignaler(): ?int
    {
        return $this->signaler;
    }

    public function setSignaler(int $signaler): self
    {
        $this->signaler = $signaler;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * @param mixed $idUtilisateur
     * @return Commentaires
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param mixed $idArticle
     * @return Commentaires
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
        return $this;
    }
}
