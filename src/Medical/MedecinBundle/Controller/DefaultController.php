<?php

namespace Medical\MedecinBundle\Controller;

use Medical\MedecinBundle\Entity\CalendarEvent;
use Medical\MedecinBundle\Entity\Conseil;
use Medical\MedecinBundle\Entity\Medecin;
use Medical\MedecinBundle\Entity\Ordonnance;
use Medical\PharmacieBundle\Entity\Pharmacie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
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

    /**
     * @Route("/medecin/list", name="api_medecin_list")
     */
    public function getMedecinsAction()
    {


        $medecins = $this->get('doctrine.orm.entity_manager')
            ->getRepository('MedecinBundle:Medecin')
            ->createQueryBuilder('e')
            ->join('e.user', 'r')
            ->where('r.enabled = 1')
            ->getQuery()
            ->getResult();


        $encoders = array(new JsonEncode());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $list = array_map(function ($entry) use ($serializer) {
            $entry->setImage(null);
            return $serializer->serialize($entry, 'json');
        }, $medecins);

        return new JsonResponse($list);
    }


    /**
     * @Route("/hobitale/list", name="api_hopitale_list")
     */
    public function getHopitalesAction()
    {

        $hopitales = $this->get('doctrine.orm.entity_manager')
            ->getRepository('HopitaleBundle:Hopitale')
            ->createQueryBuilder('e')
            ->join('e.user', 'r')
            ->where('r.enabled = 1')
            ->getQuery()
            ->getResult();


        $encoders = array(new JsonEncode());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $list = array_map(function ($entry) use ($serializer) {
            $entry->setImage(null);
            return $serializer->serialize($entry, 'json');
        }, $hopitales);

        return new JsonResponse($list);
    }


    /**
     * @Route("/laboratoires/list", name="api_laboratoire_list")
     */
    public function getLaboratoiresAction()
    {

        $laboratoires = $this->get('doctrine.orm.entity_manager')
            ->getRepository('LaboratoireBundle:Laboratoire')
            ->createQueryBuilder('e')
            ->join('e.user', 'r')
            ->where('r.enabled = 1')
            ->getQuery()
            ->getResult();


        $encoders = array(new JsonEncode());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $list = array_map(function ($entry) use ($serializer) {
            $entry->setImage(null);
            return $serializer->serialize($entry, 'json');
        }, $laboratoires);

        return new JsonResponse($list);
    }

    /**
     * @Route("/pharmacies/list", name="api_pharmacie_list")
     */
    public function getPharmaciesAction()
    {

        $pharmacies = $this->get('doctrine.orm.entity_manager')
            ->getRepository('PharmacieBundle:Pharmacie')
            ->createQueryBuilder('e')
            ->join('e.user', 'r')
            ->where('r.enabled = 1')
            ->getQuery()
            ->getResult();

$data = array();
        /**
         * @var $pharmacie Pharmacie
         */
        foreach ($pharmacies as $pharmacie){
            $img = $pharmacie->getImage();
            $var = explode('web', $img);
            $pharmacie->setImage('/siwar_pfe/web' . $var[1]);

            $data[]=['nom'=>$pharmacie->getNomPharmacie(),
                'image'=>$pharmacie->getImage(),
                'num_tel'=>$pharmacie->getTelPharmacie(),
                'fax'=>$pharmacie->getFaxPharmacie(),
                'site_web'=>$pharmacie->getSiteWeb(),
                'mail'=>$pharmacie->getUser()->getEmail(),
                'adresse'=>$pharmacie->getAdresse(),
                'ouverture'=>$pharmacie->getHOuverture(),
                'fermeture'=>$pharmacie->getHFermeture(),
                'type'=>$pharmacie->getType()
            ];

        }

//        $encoders = array(new JsonEncode());
//        $normalizers = array(new ObjectNormalizer());
//
//        $serializer = new Serializer($normalizers, $encoders);
//
//        $list = array_map(function ($entry) use ($serializer) {
////            $entry->setImage(null);
//            return $serializer->serialize($entry, 'json');
//        }, $pharmacies);
//
//        dump($pharmacies);die;

        return new JsonResponse($data);
    }

    /**
     * @Route("/medical/inscription", name="api_medical_inscription")
     */
    public function postMedicalInscriptionAction()
    {
        $email = $_POST["email_user"];
        $nom = $_POST["nom_user"];
//        $sexe = $_POST["sex_user"];
        $password = $_POST["password_user"];

        $response = array();
        $userManager = $this->get('fos_user.user_manager');
        $email_exist = $userManager->findUserByEmail($email);
        if ($email_exist) {
            $code = "échec d'inscription";
            $message = "Utilisateur Déjà existant";
            array_push($response, array("code" => $code, "message" => $message));

            return new JsonResponse($response);
        }

        $user = $userManager->createUser();
        $user->setUsername($nom);
        $user->setEmail($email);
        $user->setEmailCanonical($email);
        $user->setEnabled(true);
        // this method will encrypt the password with the default settings :)
        $user->setPlainPassword($password);

        $userManager->updateUser($user);

        $code = "Enregistrement réussi";
        $message = "Merci de vous être inscrit";
        array_push($response, array("code" => $code, "message" => $message));
        return new JsonResponse($response);

    }

    /**
     * @Route("/medical/connextion", name="api_medical_connextion")
     */
    public function postMedicalConnextionAction(Request $request)
    {

        $email = $_POST["email_user"];
        $password = $_POST["password_user"];
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);
        if (is_null($user))
            return new JsonResponse("Échec de la connexion");

        $isValid = $this->get('security.password_encoder')
            ->isPasswordValid($user, $password);

        if (!$isValid)
            return new JsonResponse("Échec de la connexion");

        return new JsonResponse("Succes");

    }

    /**
     * @Route("/medical/rendez-vous", name="api_medical_rendez_vouz")
     */
    public function postMedicalRendezVousAction()
    {
        $heure = $_POST["heure_rdv"];
        $date = $_POST["date_rdv"];
        $user = $_POST["user"];
        $doctor = $_POST["docteur"];

        $em = $this->getDoctrine()->getManager();
        $calendarEvent = new CalendarEvent();
        $calendarEvent->setStartDate($heure)
            ->setEndDate($date)
            ->setIdUser($user)
            ->setIdDocteur($doctor);

        $em->persist($calendarEvent);
        $em->flush();

        return new JsonResponse('merci');

    }

    /**
     * @Route("/ordonnance/pharmacie", name="api_medical_rendez_vouz")
     */
    public function postOrdonnanceVousAction()
    {
        $id_pharmacie = $_POST["id_pharmacie"];
        $email = $_POST["email_user"];
        $capture = $_POST["capture"];
        $message = $_POST["message"];

        $response = array();
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);

        if ($user) {
            $code = "échec d'inscription";
            $message = "Utilisateur Déjà existant";
            array_push($response, array("code" => $code, "message" => $message));

            return new JsonResponse($response);
        }

        $em = $this->getDoctrine()->getManager();

        $ordo = new Ordonnance();
        $ordo->setIdPhar($id_pharmacie)
            ->setIdUser($user->getId())
            ->setTextImage($capture)
            ->setMessage($message);

        $em->persist($ordo);
        $em->flush();

        return new JsonResponse('Ordonnace a été envoyer');

    }


    /**
     * @Route("/list/conseil", name="api_conseil_list")
     */
    public function getConseilsAction()
    {

        $em = $this->getDoctrine()->getManager();

        $conseils = $em->getRepository('MedecinBundle:Conseil')->findAll();

        foreach ($conseils as $conseil){
            $img = $conseil->getImage();
            $var = explode('web', $img);
            $conseil->setImage('http://localhost/siwar_pfe/web' . $var[1]);
        }

        $encoders = array(new JsonEncode());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $list = array_map(function ($entry) use ($serializer) {
            return $serializer->serialize($entry, 'json');
        }, $conseils);
//dump($conseils);
        return new JsonResponse($list);
    }


}
