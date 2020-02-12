<?php


namespace App\Entity;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="newsletter")
 * @ORM\Entity(repositoryClass="App\Repository\NewsletterRepository")
 */
class Newsletter extends AbstractController
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
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="NewsletterArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user" , referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @ORM\Column(name="email",type="string", length=60)
     */
    private $email;

    /**
     * @ORM\Column(name="date_registre",type="datetime")
     */
    private $dateRegistre;

    /**
     * @ORM\Column(name="active",type="string", length=40)
     */
    private $active;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Newsletter
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Utilisateur
     */
    public function getIdUtilisateur(): Utilisateur
    {
        return $this->idUtilisateur;
    }

    /**
     * @param Utilisateur $idUtilisateur
     * @return Newsletter
     */
    public function setIdUtilisateur(?Utilisateur $idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Newsletter
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


    public function getDateRegistre(): ?\DateTimeInterface
    {
        return $this->dateRegistre;
    }


    public function setDateRegistre(\DateTimeInterface $dateRegistre): self
    {
        $this->dateRegistre = $dateRegistre;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     * @return Newsletter
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }



}