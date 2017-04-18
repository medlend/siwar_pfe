<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:41
 */

namespace Medical\MedecinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="medecin")
 */
class Medecin
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=256)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=128, name="num_tel")
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $fax;

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
     * @ORM\ManyToOne(targetEntity="Medical\MedecinBundle\Entity\Specialite", inversedBy="medecin")
     */
    private $specialite;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Medecin
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Medecin
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param mixed $numTel
     * @return Medecin
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     * @return Medecin
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
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
     * @return Medecin
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
     * @return Medecin
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
     * @return Medecin
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
     * @return Medecin
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
     * @return Medecin
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
     * @return Medecin
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param mixed $specialite
     * @return Medecin
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
        return $this;
    }




}