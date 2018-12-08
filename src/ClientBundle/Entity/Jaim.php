<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jaim
 *
 * @ORM\Table(name="jaim", indexes={@ORM\Index(name="ind1", columns={"id_client"}), @ORM\Index(name="ind2", columns={"idroduit"})})
 * @ORM\Entity
 */
class Jaim
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
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idroduit", referencedColumnName="id")
     * })
     */
    private $idroduit;

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
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \User
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @param \User $idClient
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;
    }

    /**
     * @return \Produit
     */
    public function getIdroduit()
    {
        return $this->idroduit;
    }

    /**
     * @param \Produit $idroduit
     */
    public function setIdroduit($idroduit)
    {
        $this->idroduit = $idroduit;
    }


}

