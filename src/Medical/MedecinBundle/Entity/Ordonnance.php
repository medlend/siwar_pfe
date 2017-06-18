<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:41
 */

namespace Medical\MedecinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ordonnance")
 */
class Ordonnance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $textImage;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;


    /**
     * @ORM\Column(type="integer",  nullable=true, unique=true)
     */
    private $idUser;

    /**
     * @ORM\Column(type="integer",  nullable=true, unique=true)
     */
    private $idPhar;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Ordonnance
     */
    public function setMessage($message)
    {
        $this->message = $message;
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
     * @return Ordonnance
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTextImage()
    {
        return $this->textImage;
    }

    /**
     * @param mixed $textImage
     * @return Ordonnance
     */
    public function setTextImage($textImage)
    {
        $this->textImage = $textImage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     * @return Ordonnance
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdPhar()
    {
        return $this->idPhar;
    }

    /**
     * @param mixed $idPhar
     * @return Ordonnance
     */
    public function setIdPhar($idPhar)
    {
        $this->idPhar = $idPhar;
        return $this;
    }


}