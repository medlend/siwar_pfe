<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:41
 */

namespace Medical\HopitaleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="hopitale")
 */
class Hopitale
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $nomHopitale;

    /**
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $mailHopitale;

    /**
     * @ORM\Column(type="string", length=128, name="num_tel", nullable=true)
     */
    private $telHopitale;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $faxHopitale;

    /**
     * @ORM\Column(type="string", length=128, name="h_ouverture", nullable=true)
     */
    private $hOuverture;

    /**
     * @ORM\Column(type="string", length=128, name="h_fermeture", nullable=true)
     */
    private $hFermeture;

    /**
     * @ORM\Column(type="string", length=128, name="site_web", nullable=true)
     */
    private $siteWeb;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity="User\UserBundle\Entity\Utilisateur", cascade={"persist","remove"})
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\Image(
     *      maxSize="1024k",
     *      mimeTypes = { "image/png","image/jpeg", "image/jpg", "image/gif" },
     *      mimeTypesMessage = "Please upload a valid Image"
     * )
     */
    private $image;

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     * @return Hopitale
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     * @return Hopitale
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Hopitale
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomHopitale()
    {
        return $this->nomHopitale;
    }

    /**
     * @param mixed $nomHopitale
     * @return Hopitale
     */
    public function setNomHopitale($nomHopitale)
    {
        $this->nomHopitale = $nomHopitale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMailHopitale()
    {
        return $this->mailHopitale;
    }

    /**
     * @param mixed $mailHopitale
     * @return Hopitale
     */
    public function setMailHopitale($mailHopitale)
    {
        $this->mailHopitale = $mailHopitale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelHopitale()
    {
        return $this->telHopitale;
    }

    /**
     * @param mixed $telHopitale
     * @return Hopitale
     */
    public function setTelHopitale($telHopitale)
    {
        $this->telHopitale = $telHopitale;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFaxHopitale()
    {
        return $this->faxHopitale;
    }

    /**
     * @param mixed $faxHopitale
     * @return Hopitale
     */
    public function setFaxHopitale($faxHopitale)
    {
        $this->faxHopitale = $faxHopitale;
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
     * @return Hopitale
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
     * @return Hopitale
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
     * @return Hopitale
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
     * @return Hopitale
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
     * @return Hopitale
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
     * @return Hopitale
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }




}