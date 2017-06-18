<?php

namespace AppBundle\Controller;

use Medical\MedecinBundle\Entity\Message;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\Utilisateur;

class DefaultController extends Controller
{

    /**
     * @Route("/admin", name="homepage_admin")
     */
    public function indexAdminAction(Request $request)
    {
        // replace this example code with whatever you need

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('MedecinBundle:Message')->findAll();

        $boiteRecep=[];
        foreach ($messages as $value){
           $user = $em->getRepository(Utilisateur::class)->find($value->getIdUser());

           $msg= json_decode($value->getText(),true);
            $boiteRecep[] = [$user->getUsername(), $msg[count($msg)-1],$value->getIdUser()];
        }

        return $this->render('default/adminIndex.html.twig', [
            'messages' => $boiteRecep,
        ]);
    }

    /**
     * @Route("/registration/type", name="registration_type")
     */
    public function registrationTypeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/registration.html.twig', [

        ]);
    }


    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="admin_contact")
     * @Method({"GET"})
     */
    public function contactAction(Utilisateur $utilisateur)
    {

        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $utilisateur->getId()));

        $text = array();
        if (!is_null($messageEntity))
            $text = json_decode($messageEntity->getText(), true);

//dump($text);die;
        return $this->render('default/contact.html.twig', array(
            'user' => $utilisateur,
            'text' => $text
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="admin_contact_post")
     * @Method({"POST"})
     */
    public function contactPostAction(Utilisateur $utilisateur, Request $request)
    {
        $idUser = $utilisateur->getId();
        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $idUser));

        $message = $request->request->get('message');

        $text = array();

        if (!empty($messageEntity))
            $text = json_decode($messageEntity->getText(), true);


        $text[] = ["admin", $message];

        $jsonText = json_encode($text);

        $query = "INSERT INTO message (text,id_user) VALUES ('$jsonText', $idUser) ON DUPLICATE KEY UPDATE text = '$jsonText';";

        $em = $this->getDoctrine()->getManager();

        $statement = $em->getConnection()->prepare($query);
        $statement->execute();


        return $this->render('default/contact.html.twig', array(
            'user' => $utilisateur,
            'text' => $text
        ));
    }



}
