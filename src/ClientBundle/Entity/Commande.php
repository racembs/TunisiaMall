<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", indexes={@ORM\Index(name="idClient", columns={"idClient"})})
 * @ORM\Entity
 */
class Commande
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
     * @var integer
     *
     * @ORM\Column(name="paiement", type="integer", nullable=true)
     */
    private $paiement;

    /**
     * @var integer
     *
     * @ORM\Column(name="livraison", type="integer", nullable=true)
     */
    private $livraison;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=40, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="dateLivraison", type="string", length=66, nullable=true)
     */
    private $datelivraison;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat", type="string", length=30, nullable=true)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="num", type="integer", nullable=true)
     */
    private $num;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=20, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=20, nullable=true)
     */
    private $pays;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     */
    private $idclient;

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
     * @return int
     */
    public function getPaiement()
    {
        return $this->paiement;
    }

    /**
     * @param int $paiement
     */
    public function setPaiement($paiement)
    {
        $this->paiement = $paiement;
    }

    /**
     * @return int
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     * @param int $livraison
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getDatelivraison()
    {
        return $this->datelivraison;
    }

    /**
     * @param string $datelivraison
     */
    public function setDatelivraison($datelivraison)
    {
        $this->datelivraison = $datelivraison;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param int $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

    /**
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param string $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }

    /**
     * @return \User
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    /**
     * @param \User $idclient
     */
    public function setIdclient($idclient)
    {
        $this->idclient = $idclient;
    }


}

