<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
{

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
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
        if($this->getStatus() == 'member'){
            return [
                'ROLE_MEMBER'
            ];
        }
        else{
            return ['IS_AUTHENTICATED_ANONYMOUSLY'];
        }
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string|null The encoded password if any
     */
    public function getPassword()
    {
        return $this->mdp;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->emailUtilisateur;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
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
    private $emailUtilisateur;

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
     * @ORM\OneToMany(targetEntity="Articles", mappedBy="idUtilisateur")
     */
    private $UtilisateurArticle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaires", mappedBy="idUtilisateur")
     */
    private $UtilisateurCommentaires;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Organisateur", mappedBy="idUtilisateurs")
     */
    private $organisateurs;


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

    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    public function setEmailUtilisateur(string $emailUtilisateur): self
    {
        $this->emailUtilisateur = $emailUtilisateur;

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
     * @return ArrayCollection
     */
    public function getOrganisateurs(): ArrayCollection
    {
        return $this->organisateurs;
    }

    /**
     * @param ArrayCollection $organisateurs
     * @return Utilisateur
     */
    public function setOrganisateurs(ArrayCollection $organisateurs): Utilisateur
    {
        $this->organisateurs = $organisateurs;
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
