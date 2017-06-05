<?php

namespace Medical\MedecinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use User\UserBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        /**
         * @var $user Utilisateur
         */
        $user = $this->getUser();

        if (!is_null($user)) {
            if ($user->hasRole('ROLE_SUPER_ADMIN')) {

                return $this->redirect($this->generateUrl('homepage_admin'));
            }
            if ($user->hasRole('ROLE_MEDECIN')) {

                $medecin = $this->get('doctrine')
                    ->getRepository('MedecinBundle:Medecin')
                    ->findOneBy(array('user' => $user));

                return $this->redirect($this->generateUrl('medecin_calendar', array('id' => $medecin->getId())));
            }

            if ($user->hasRole('ROLE_LABORATOIRE')) {

                $labo = $this->get('doctrine')
                    ->getRepository('LaboratoireBundle:Laboratoire')
                    ->findOneBy(array('user' => $user));

                return $this->redirect($this->generateUrl('laboratoire_show', array('id' => $labo->getId())));
            }

            if ($user->hasRole('ROLE_HOPITALE')) {

                $hopi = $this->get('doctrine')
                    ->getRepository('HopitaleBundle:Hopitale')
                    ->findOneBy(array('user' => $user));

                return $this->redirect($this->generateUrl('hopitale_show', array('id' => $hopi->getId())));
            }

            if ($user->hasRole('ROLE_PHARMACIE')) {


                $pha = $this->get('doctrine')
                    ->getRepository('PharmacieBundle:Pharmacie')
                    ->findOneBy(array('user' => $user));

                return $this->redirect($this->generateUrl('pharmacie_show', array('id' => $pha->getId())));
            }

        }
        return $this->redirect($this->generateUrl('fos_user_security_login'));

    }
}
