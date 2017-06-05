<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 05/04/17
 * Time: 09:41
 */

namespace Medical\LaboratoireBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="laboratoire")
 */
class Laboratoire
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
    private $nomLab;

    /**
     * @ORM\Column(type="string", length=4000)
     */
    private $mailLab;

    /**
     * @ORM\Column(type="string", length=128, name="num_tel")
     */
    private $telLab;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $faxLab;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }







}