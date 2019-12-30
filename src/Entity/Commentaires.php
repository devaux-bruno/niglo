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
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="UtilisateurCommentaires", orphanRemoval=true)
     */
    private $idUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Articles", mappedBy="ArticlesCommentaires", orphanRemoval=true)
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

    public function __construct()
    {
        $this->idUtilisateur = new ArrayCollection();
        $this->idArticle = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getIdUtilisateur(): Collection
    {
        return $this->idUtilisateur;
    }

    public function addIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if (!$this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur[] = $idUtilisateur;
            $idUtilisateur->setUtilisateurCommentaires($this);
        }

        return $this;
    }

    public function removeIdUtilisateur(Utilisateur $idUtilisateur): self
    {
        if ($this->idUtilisateur->contains($idUtilisateur)) {
            $this->idUtilisateur->removeElement($idUtilisateur);
            // set the owning side to null (unless already changed)
            if ($idUtilisateur->getUtilisateurCommentaires() === $this) {
                $idUtilisateur->setUtilisateurCommentaires(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Articles[]
     */
    public function getIdArticle(): Collection
    {
        return $this->idArticle;
    }

    public function addIdArticle(Articles $idArticle): self
    {
        if (!$this->idArticle->contains($idArticle)) {
            $this->idArticle[] = $idArticle;
            $idArticle->setArticlesCommentaires($this);
        }

        return $this;
    }

    public function removeIdArticle(Articles $idArticle): self
    {
        if ($this->idArticle->contains($idArticle)) {
            $this->idArticle->removeElement($idArticle);
            // set the owning side to null (unless already changed)
            if ($idArticle->getArticlesCommentaires() === $this) {
                $idArticle->setArticlesCommentaires(null);
            }
        }

        return $this;
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
}
