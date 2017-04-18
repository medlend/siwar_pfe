<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/11/16
 * Time: 10:30
 */

namespace User\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class Utilisateur extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     * @return Utilisateur
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }







    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}