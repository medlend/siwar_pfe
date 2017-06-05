<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:41
 */

namespace Medical\PharmacieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="pharmacie")
 */
class Pharmacie
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    private $nomPharmacie;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    private $mailPharmacie;

    /**
     * @ORM\Column(type="string", length=128, name="num_tel")
     */
    private $telPharmacie;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $faxPharmacie;

    /**
     * @ORM\Column(type="string", length=128, name="h_ouverture")
     */
    private $hOuverture;

    /**
     * @ORM\Column(type="string", length=128, name="h_fermeture")
     */
    private $hFermeture;

    /**
     * @ORM\Column(type="string", length=128, name="site_web")
     */
    private $siteWeb;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity="User\UserBundle\Entity\Utilisateur", cascade={"persist","remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $type;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Pharmacie
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomPharmacie()
    {
        return $this->nomPharmacie;
    }

    /**
     * @param mixed $nomPharmacie
     * @return Pharmacie
     */
    public function setNomPharmacie($nomPharmacie)
    {
        $this->nomPharmacie = $nomPharmacie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailPharmacie()
    {
        return $this->mailPharmacie;
    }

    /**
     * @param mixed $mailPharmacie
     * @return Pharmacie
     */
    public function setMailPharmacie($mailPharmacie)
    {
        $this->mailPharmacie = $mailPharmacie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelPharmacie()
    {
        return $this->telPharmacie;
    }

    /**
     * @param mixed $telPharmacie
     * @return Pharmacie
     */
    public function setTelPharmacie($telPharmacie)
    {
        $this->telPharmacie = $telPharmacie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFaxPharmacie()
    {
        return $this->faxPharmacie;
    }

    /**
     * @param mixed $faxPharmacie
     * @return Pharmacie
     */
    public function setFaxPharmacie($faxPharmacie)
    {
        $this->faxPharmacie = $faxPharmacie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHOuverture()
    {
        return $this->hOuverture;
    }

    /**
     * @param mixed $hOuverture
     * @return Pharmacie
     */
    public function setHOuverture($hOuverture)
    {
        $this->hOuverture = $hOuverture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHFermeture()
    {
        return $this->hFermeture;
    }

    /**
     * @param mixed $hFermeture
     * @return Pharmacie
     */
    public function setHFermeture($hFermeture)
    {
        $this->hFermeture = $hFermeture;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSiteWeb()
    {
        return $this->siteWeb;
    }

    /**
     * @param mixed $siteWeb
     * @return Pharmacie
     */
    public function setSiteWeb($siteWeb)
    {
        $this->siteWeb = $siteWeb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     * @return Pharmacie
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     * @return Pharmacie
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Pharmacie
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Pharmacie
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }



}