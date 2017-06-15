<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:30
 */

namespace Medical\MedecinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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

    public function __toString() {
        return $this->nomSpecialite;
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