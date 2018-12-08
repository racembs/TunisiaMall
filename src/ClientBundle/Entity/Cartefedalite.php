<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cartefedalite
 *
 * @ORM\Table(name="cartefedalite", indexes={@ORM\Index(name="index1", columns={"idClient"}), @ORM\Index(name="index2", columns={"idEnseigne"})})
 * @ORM\Entity
 */
class Cartefedalite
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
     * @ORM\Column(name="nbrpts", type="integer", nullable=false)
     */
    private $nbrpts;
    /**
     * @var integer
     *
     * @ORM\Column(name="totale", type="integer", nullable=false)
     */
    private $totale;


    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="string", length=30,nullable=false)
     */
    private $type;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idClient", referencedColumnName="id")
     * })
     */
    private $idclient;

    /**
     * @var \Enseigne
     *
     * @ORM\ManyToOne(targetEntity="Enseigne")
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */

    public function getNbrpts()
    {
        return $this->nbrpts;
    }

    /**
     * @param int $nbrpts
     */
    public function setNbrpts($nbrpts)
    {
        $this->nbrpts = $nbrpts;
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
     * @return int
     */
    public function getTotale()
    {
        return $this->totale;
    }

    /**
     * @param int $totale
     */
    public function setTotale($totale)
    {
        $this->totale = $totale;
    }
public function sendsms($number,$msg){


    // Authorisation details.
    $username = "racem.bensaid@esprit.tn";
    $hash = "d1b4a8bb5f4516b5bc961e22eb2c7be8aa65ada76e5a09e8447b5c941db5e429";

    // Config variables. Consult http://api.txtlocal.com/docs for more info.
    $test = "0";

    // Data for text message. This is the text message data.
    $sender = "API Test"; // This is who the message appears to be from.
    $numbers = $number; // A single number or a comma-seperated list of numbers
    $message = $msg;
    // 612 chars or less
    // A single number or a comma-seperated list of numbers
    $message = urlencode($message);
    $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
    $ch = curl_init('http://api.txtlocal.com/send/?');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch); // This is the result from the API
    curl_close($ch);


}

}

