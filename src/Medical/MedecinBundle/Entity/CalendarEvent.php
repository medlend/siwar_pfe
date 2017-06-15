<?php

namespace Medical\MedecinBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="rendez_vous")
 */
class CalendarEvent
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $idDocteur;

    /**
     *
     * @ORM\Column(type="string", length=248, nullable=true)
     */
    private $idUser;

    /**
     * @var string
     * @ORM\Column(type="string", length=248, nullable=true)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $startDate;
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $endDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return CalendarEvent
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @return CalendarEvent
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }



    /**
     * @return mixed
     */
    public function getIdDocteur()
    {
        return $this->idDocteur;
    }

    /**
     * @param mixed $idDocteur
     * @return CalendarEvent
     */
    public function setIdDocteur($idDocteur)
    {
        $this->idDocteur = $idDocteur;
        return $this;
    }



    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return CalendarEvent
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     * @return CalendarEvent
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param string $endDate
     * @return CalendarEvent
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }



}