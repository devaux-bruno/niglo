<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naissance;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     */
    private $sexe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @return mixed
     */
    public function getIdUtilisateurService()
    {
        return $this->idUtilisateurService;
    }

    /**
     * @param mixed $idUtilisateurService
     * @return Utilisateur
     */
    public function setIdUtilisateurService($idUtilisateurService)
    {
        $this->idUtilisateurService = $idUtilisateurService;
        return $this;
    }

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="ServiceUtilisateur")
     */
    private $idUtilisateurService;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="idUtilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UtilisateurArticle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaires", inversedBy="idUtilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UtilisateurCommentaires;

    /**
     * @return mixed
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * @param mixed $dateNaissance
     * @return Utilisateur
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    /**
     * @param mixed $dateInscription
     * @return Utilisateur
     */
    public function setDateInscription($dateInscription)
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getNaissance(): ?string
    {
        return $this->naissance;
    }

    public function setNaissance(string $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSexe(): ?int
    {
        return $this->sexe;
    }

    public function setSexe(int $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getUtilisateurArticle(): ?Articles
    {
        return $this->UtilisateurArticle;
    }

    public function setUtilisateurArticle(?Articles $UtilisateurArticle): self
    {
        $this->UtilisateurArticle = $UtilisateurArticle;

        return $this;
    }

    public function getUtilisateurCommentaires(): ?Commentaires
    {
        return $this->UtilisateurCommentaires;
    }

    public function setUtilisateurCommentaires(?Commentaires $UtilisateurCommentaires): self
    {
        $this->UtilisateurCommentaires = $UtilisateurCommentaires;

        return $this;
    }
    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     * @return Utilisateur
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

}
