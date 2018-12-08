<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parking
 *
 * @ORM\Table(name="parking", indexes={@ORM\Index(name="indexC", columns={"idClient"})})
 * @ORM\Entity
 */
class Parking
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
     * @ORM\Column(name="numPlaces", type="integer", nullable=false)
     */
    private $numplaces;

    /**
     * @var integer
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     */
    private $idclient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureEntree", type="time", nullable=true)
     */
    private $heureentree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heureSortie", type="time", nullable=true)
     */
    private $heuresortie;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePark", type="date", nullable=true)
     */
    private $datepark;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=200, nullable=true)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="niveau", type="string", length=20, nullable=true)
     */
    private $niveau;


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
    public function getNumplaces()
    {
        return $this->numplaces;
    }

    /**
     * @param int $numplaces
     */
    public function setNumplaces($numplaces)
    {
        $this->numplaces = $numplaces;
    }

    /**
     * @return int
     */
    public function getIdclient()
    {
        return $this->idclient;
    }

    /**
     * @param int $idclient
     */
    public function setIdclient($idclient)
    {
        $this->idclient = $idclient;
    }

    /**
     * @return \DateTime
     */
    public function getHeureentree()
    {
        return $this->heureentree;
    }

    /**
     * @param \DateTime $heureentree
     */
    public function setHeureentree($heureentree)
    {
        $this->heureentree = $heureentree;
    }

    /**
     * @return \DateTime
     */
    public function getHeuresortie()
    {
        return $this->heuresortie;
    }

    /**
     * @param \DateTime $heuresortie
     */
    public function setHeuresortie($heuresortie)
    {
        $this->heuresortie = $heuresortie;
    }

    /**
     * @return \DateTime
     */
    public function getDatepark()
    {
        return $this->datepark;
    }

    /**
     * @param \DateTime $datepark
     */
    public function setDatepark($datepark)
    {
        $this->datepark = $datepark;
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
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * @param string $niveau
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;
    }


}

