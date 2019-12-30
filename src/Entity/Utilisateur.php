<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, \Serializable
{

    /*
     * Permet de définir un tableau de role, il peut y en avoir plusieurs
     */
    public function getRoles() : array
    {
        if($this->getStatus() == 'superadmin'){
        return [
            'ROLE_SUPERADMIN'
        ];
        }
        if ($this->getStatus() == 'admin'){
            return [
                'ROLE_ADMIN'
            ];
        }
        else{
            return [
                'ROLE_MEMBER'
            ];
        }
    }


    /*
     * la fonction password permet de retourner le mdp de la bdd
     */
    public function getPassword() :?string
    {
        return $this->mdp;
    }


    public function getSalt()
    {
        return null;
    }


    /*
     * retour l'adresse mail de la bdd
     */
    public function getUsername() :string
    {
        return $this->email;
    }


    /*
     * permet d'éviter les donnée sensible comme les mdp
     */
    public function eraseCredentials()
    {

    }



    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="status",type="string", length=60)
     */
    private $status;

    /**
     * @ORM\Column(name="pseudo",type="string", length=60)
     */
    private $pseudo;

    /**
     * @ORM\Column(name="nom",type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom",type="string", length=60)
     */
    private $prenom;

    /**
     * @ORM\Column(name="email",type="string", length=60)
     */
    private $email;

    /**
     * @ORM\Column(name="mdp",type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $naissance;

    /**
     * @ORM\Column(name="ville",type="string", length=60)
     */
    private $ville;

    /**
     * @ORM\Column(name="photo",type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\Column(name="sexe",type="integer")
     */
    private $sexe;

    /**
     * @var DateTime
     * @ORM\Column(name="date_inscription",type="datetime")
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
     * @ORM\OneToMany(targetEntity="App\Entity\Service", mappedBy="ServiceUtilisateur")
     */
    private $idUtilisateurService;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Articles", inversedBy="idUtilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $UtilisateurArticle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commentaires", inversedBy="idUtilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $UtilisateurCommentaires;

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

    /**
     * @return DateTime
     */
    public function getNaissance(): ?DateTime
    {
        return $this->naissance;
    }

    /**
     * @param DateTime $naissance
     * @return Utilisateur
     */
    public function setNaissance(DateTime $naissance): Utilisateur
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

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}
