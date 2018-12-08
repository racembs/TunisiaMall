<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enseigne
 *
 * @ORM\Table(name="enseigne", indexes={@ORM\Index(name="proprietaireindex", columns={"idproprietaire"})})
 * @ORM\Entity
 */
class Enseigne
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=30, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=false)
     */
    private $categorie;
    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=true)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="capaciteMax", type="integer", nullable=false)
     */
    private $capacitemax;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacite", type="integer", nullable=false)
     */
    private $capacite;

    /**
     * @var float
     *
     * @ORM\Column(name="pourcentagefidalite", type="float", precision=10, scale=0, nullable=false)
     */
    private $pourcentagefidalite;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idproprietaire", referencedColumnName="id")
     * })
     */
    private $idproprietaire;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return int
     */
    public function getCapacitemax()
    {
        return $this->capacitemax;
    }

    /**
     * @param int $capacitemax
     */
    public function setCapacitemax($capacitemax)
    {
        $this->capacitemax = $capacitemax;
    }

    /**
     * @return int
     */
    public function getCapacite()
    {
        return $this->capacite;
    }

    /**
     * @param int $capacite
     */
    public function setCapacite($capacite)
    {
        $this->capacite = $capacite;
    }

    /**
     * @return float
     */
    public function getPourcentagefidalite()
    {
        return $this->pourcentagefidalite;
    }

    /**
     * @param float $pourcentagefidalite
     */
    public function setPourcentagefidalite($pourcentagefidalite)
    {
        $this->pourcentagefidalite = $pourcentagefidalite;
    }

    /**
     * @return \User
     */
    public function getIdproprietaire()
    {
        return $this->idproprietaire;
    }

    /**
     * @param \User $idproprietaire
     */
    public function setIdproprietaire($idproprietaire)
    {
        $this->idproprietaire = $idproprietaire;
    }


}

