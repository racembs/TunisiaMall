<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offresemplois
 *
 * @ORM\Table(name="offresemplois", indexes={@ORM\Index(name="postindex", columns={"idPost"})})
 * @ORM\Entity(repositoryClass="ClientBundle\Entity\OffresemploisRepository")
 */
class Offresemplois
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
     * @ORM\Column(name="poste", type="string", length=30, nullable=false)
     */
    private $poste;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_experation", type="date", nullable=false)
     */
    private $dateExperation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_poste", type="date", nullable=false)
     */
    private $datePoste;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var \Personne
     *
     * @ORM\ManyToOne(targetEntity="Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPost", referencedColumnName="id")
     * })
     */
    private $idpost;

    /**
     * @var float
     *
     * @ORM\Column(name="sal", type="float",precision=10,scale=0, nullable=true)
     */
    private $sal;

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
     * @var string
     *
     * @ORM\Column(name="competance", type="string", length=100, nullable=false)
     */
    private $competance;

    /**
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * @param string $poste
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;
    }

    /**
     * @return \DateTime
     */
    public function getDateExperation()
    {
        return $this->dateExperation;
    }

    /**
     * @param \DateTime $dateExperation
     */
    public function setDateExperation($dateExperation)
    {
        $this->dateExperation = $dateExperation;
    }

    /**
     * @return \DateTime
     */
    public function getDatePoste()
    {
        return $this->datePoste;
    }

    /**
     * @param \DateTime $datePoste
     */
    public function setDatePoste($datePoste)
    {
        $this->datePoste = $datePoste;
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
     * @return \Personne
     */
    public function getIdpost()
    {
        return $this->idpost;
    }

    /**
     * @param \Personne $idpost
     */
    public function setIdpost($idpost)
    {
        $this->idpost = $idpost;
    }

    /**
     * @param float $sal
     */
    public function setSal($sal)
    {
        $this->sal = $sal;
    }

    /**
     * @return float
     */
    public function getSal()
    {
        return $this->sal;
    }

    /**
     * @return string
     */
    public function getCompetance()
    {
        return $this->competance;
    }

    /**
     * @param string $competance
     */
    public function setCompetance($competance)
    {
        $this->competance = $competance;
    }
}

