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
     * @ORM\Column(type="integer")
     */
    private $idDocteur;

    /**
     * @var string
     * @ORM\Column(type="string", length=248)
     */
    private $title;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $startDate;
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
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
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return CalendarEvent
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return CalendarEvent
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }



}