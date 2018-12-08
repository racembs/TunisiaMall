<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", indexes={@ORM\Index(name="ensindex", columns={"idEnseigne"})})
 * @ORM\Entity
 */
class Produit
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
     * @var integer
     *
     * @ORM\Column(name="reference", type="integer", nullable=false)
     */
    private $reference;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=30, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=30, nullable=false)
     */
    private $categorie;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="promo", type="float", precision=10, scale=0, nullable=false)
     */
    private $promo;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=30, nullable=false)
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="NbJaimes", type="integer", nullable=true)
     */
    private $nbjaimes;


    /**
     * @var \Date
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */

    private $date;

    /**
     * @var \Enseigne
     *
     * @ORM\ManyToOne(targetEntity="Enseigne",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEnseigne", referencedColumnName="id")
     * })
     */
    private $idenseigne;

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
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param int $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
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
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
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
     * @return float
     */
    public function getPromo()
    {
        return $this->promo;
    }

    /**
     * @param float $promo
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;
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
     * @return int
     */
    public function getNbjaimes()
    {
        return $this->nbjaimes;
    }

    /**
     * @param int $nbjaimes
     */
    public function setNbjaimes($nbjaimes)
    {
        $this->nbjaimes = $nbjaimes;
    }

    /**
     * @return \Enseigne
     */
    public function getIdenseigne()
    {
        return $this->idenseigne;
    }

    /**
     * @param \Enseigne $idenseigne
     */
    public function setIdenseigne($idenseigne)
    {
        $this->idenseigne = $idenseigne;
    }

    /**
     * @return \Date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \Date $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }


}

