<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lignecommande
 *
 * @ORM\Table(name="lignecommande", indexes={@ORM\Index(name="produndex", columns={"idProduit"}), @ORM\Index(name="cmdindex", columns={"idcommande"})})
 * @ORM\Entity
 */
class Lignecommande
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
     * @ORM\Column(name="quantite", type="integer", nullable=true)
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=true)
     */
    private $total;

/**
     * @var float
     *
     * @ORM\Column(name="totalpts", type="float", precision=10, scale=0, nullable=true)
     */
    private $totalpts;

    /**
     * @var float
     *
     * @ORM\Column(name="promo", type="float", precision=10, scale=0, nullable=true)
     */
    private $promo;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=true)
     */
    private $prix;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idProduit", referencedColumnName="id")
     * })
     */
    private $idproduit;

    /**
     * @var \Commande
     *
     * @ORM\ManyToOne(targetEntity="Commande",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcommande", referencedColumnName="id")
     * })
     */
    private $idcommande;

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
     * @return float
     */
    public function getTotalpts()
    {
        return $this->totalpts;
    }

    /**
     * @param float $totalpts
     */
    public function setTotalpts($totalpts)
    {
        $this->totalpts = $totalpts;
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
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
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
     * @return \Produit
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * @param \Produit $idproduit
     */
    public function setIdproduit($idproduit)
    {
        $this->idproduit = $idproduit;
    }

    /**
     * @return \Commande
     */
    public function getIdcommande()
    {
        return $this->idcommande;
    }

    /**
     * @param \Commande $idcommande
     */
    public function setIdcommande($idcommande)
    {
        $this->idcommande = $idcommande;
    }


}

