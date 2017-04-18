<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:30
 */

namespace Medical\MedecinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="specialite")
 */
class Specialite
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $nomSpecialite;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $image;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Medical\MedecinBundle\Entity\Medecin", mappedBy="specialite")
     */
    private $medecin;

    /**
     * @return mixed
     */
    public function getMedecin()
    {
        return $this->medecin;
    }

    /**
     * @param mixed $medecin
     * @return Specialite
     */
    public function setMedecin($medecin)
    {
        $this->medecin = $medecin;
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
     * @return Specialite
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getNomSpecialite()
    {
        return $this->nomSpecialite;
    }

    /**
     * @param mixed $nomSpecialite
     * @return Specialite
     */
    public function setNomSpecialite($nomSpecialite)
    {
        $this->nomSpecialite = $nomSpecialite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Specialite
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }





}