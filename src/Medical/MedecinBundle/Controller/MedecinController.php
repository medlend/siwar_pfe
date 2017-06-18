<?php

namespace Medical\MedecinBundle\Controller;

use Medical\MedecinBundle\Entity\CalendarEvent;
use Medical\MedecinBundle\Entity\Medecin;
use Medical\MedecinBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use User\UserBundle\Entity\Utilisateur;
use User\UserBundle\UserBundle;

/**
 * Medecin controller.
 *
 * @Route("medecin")
 */
class MedecinController extends Controller
{
    /**
     * Lists all medecin entities.
     *
     * @Route("/", name="medecin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $medecins = $em->getRepository('MedecinBundle:Medecin')->findAll();

        return $this->render('medecin/index.html.twig', array(
            'medecins' => $medecins,
        ));
    }


    /**
     * Lists all medecin entities.
     *
     * @Route("/calendar/{id}", name="medecin_calendar")
     * @Method("GET")
     */
    public function calendarAction(Medecin $medecin)
    {
        return $this->render('calendar/index.html.twig', array(
            'medecin' => $medecin
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="medecin_contact")
     * @Method({"GET"})
     */
    public function contactAction(Medecin $medecin)
    {

        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $medecin->getUser()->getId()));

        $text = array();
        if (!is_null($messageEntity))
            $text = json_decode($messageEntity->getText(), true);

//dump($text);die;
        return $this->render('medecin/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="medecin_contact_post")
     * @Method({"POST"})
     */
    public function contactPostAction(Medecin $medecin, Request $request)
    {
        $idUser = $medecin->getUser()->getId();
        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $medecin->getUser()->getId()));

        $message = $request->request->get('message');

        $text = array();

        if (!empty($messageEntity))
            $text = json_decode($messageEntity->getText(), true);


        $text[] = ["moi", $message];

        $jsonText = json_encode($text);

        $query = "INSERT INTO message (text,id_user) VALUES ('$jsonText', $idUser) ON DUPLICATE KEY UPDATE text = '$jsonText';";

        $em = $this->getDoctrine()->getManager();

        $statement = $em->getConnection()->prepare($query);
        $statement->execute();


        return $this->render('medecin/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }


    /**
     * Creates a new medecin entity.
     *
     * @Route("/new", name="medecin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $medecin = new Medecin();

        $form = $this->createForm('Medical\MedecinBundle\Form\MedecinType', $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var $user Utilisateur
             */
            $user = $medecin->getUser();
            $user->addRole('ROLE_MEDECIN')->setEnabled(true);

            $medecin->setUser($user);


//            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' .str_replace(" ", "+", $medecin->getAdresse()). '&key=AIzaSyBx4U0wGOGkj2jDW6PPIjACGl8O8YqTKhY';
//            $data = json_decode($this->curl_get_contents($url))->results[0]->geometry->location;

//            $medecin->setLatitude($data->lat)
//                ->setLongitude($data->lng);

            $medecin->setLatitude('')
                ->setLongitude('');

            $em = $this->getDoctrine()->getManager();
            $em->persist($medecin);
            $em->flush($medecin);

            return $this->redirectToRoute('medecin_show', array('id' => $medecin->getId()));
        }

        return $this->render('medecin/new.html.twig', array(
            'medecin' => $medecin,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a medecin entity.
     *
     * @Route("/{id}", name="medecin_show")
     * @Method("GET")
     */
    public function showAction(Medecin $medecin)
    {
        $deleteForm = $this->createDeleteForm($medecin);

        $img = $medecin->getImage();
        $var = explode('web', $img);
        $medecin->setImage('http://localhost/siwar_pfe/web' . $var[1]);

        $img2 = $medecin->getImage2();
        $var2 = explode('web', $img2);
        $medecin->setImage2('http://localhost/siwar_pfe/web' . $var2[1]);

        return $this->render('medecin/show.html.twig', array(
            'medecin' => $medecin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medecin entity.
     *
     * @Route("/{id}/edit", name="medecin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Medecin $medecin)
    {
        $deleteForm = $this->createDeleteForm($medecin);
        $editForm = $this->createForm('Medical\MedecinBundle\Form\MedecinType', $medecin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_edit', array('id' => $medecin->getId()));
        }

        return $this->render('medecin/edit.html.twig', array(
            'medecin' => $medecin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medecin entity.
     *
     * @Route("/delete/{id}", name="medecin_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Medecin $medecin)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($medecin);
        $em->flush($medecin);
        return $this->redirectToRoute('medecin_index');
    }

    /**
     * Deletes a hopitale entity.
     *
     * @Route("/activer/{id}", name="medecin_activer")
     * @Method("GET")
     */
    public function activerAction(Request $request, Medecin $medecin)
    {

        $userId = $medecin->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '1' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('medecin_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/deactiver/{id}", name="medecin_deactiver")
     * @Method("GET")
     */
    public function deactiverAction(Request $request, Medecin $medecin)
    {

        $userId = $medecin->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '0' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('medecin_index');
    }


    /**
     * Creates a form to delete a medecin entity.
     *
     * @param Medecin $medecin The medecin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medecin $medecin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medecin_delete', array('id' => $medecin->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    function curl_get_contents($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $data = curl_exec($ch);

        curl_close($ch);

        return $data;
    }
}
