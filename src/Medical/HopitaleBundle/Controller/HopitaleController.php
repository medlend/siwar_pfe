<?php

namespace Medical\HopitaleBundle\Controller;

use Medical\HopitaleBundle\Entity\Hopitale;
use Medical\MedecinBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hopitale controller.
 *
 * @Route("hopitale")
 */
class HopitaleController extends Controller
{
    /**
     * Lists all hopitale entities.
     *
     * @Route("/", name="hopitale_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $hopitales = $em->getRepository('HopitaleBundle:Hopitale')->findAll();

        return $this->render('hopitale/index.html.twig', array(
            'hopitales' => $hopitales,
        ));
    }

    /**
     * Creates a new hopitale entity.
     *
     * @Route("/new", name="hopitale_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $hopitale = new Hopitale();
        $form = $this->createForm('Medical\HopitaleBundle\Form\HopitaleType', $hopitale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $hopitale->getUser();
            $user->addRole('ROLE_HOPITALE')->setEnabled(true);
            $hopitale->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($hopitale);
            $em->flush($hopitale);

            return $this->redirectToRoute('hopitale_show', array('id' => $hopitale->getId()));
        }

        return $this->render('hopitale/new.html.twig', array(
            'hopitale' => $hopitale,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a hopitale entity.
     *
     * @Route("/{id}", name="hopitale_show")
     * @Method("GET")
     */
    public function showAction(Hopitale $hopitale)
    {

        $deleteForm = $this->createDeleteForm($hopitale);
        $img = $hopitale->getImage();
        $var = explode('web', $img);
        $hopitale->setImage('http://localhost/siwar_pfe/web' . $var[1]);

        return $this->render('hopitale/show.html.twig', array(
            'hopitale' => $hopitale,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hopitale entity.
     *
     * @Route("/{id}/edit", name="hopitale_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Hopitale $hopitale)
    {
        $deleteForm = $this->createDeleteForm($hopitale);
        $editForm = $this->createForm('Medical\HopitaleBundle\Form\HopitaleType', $hopitale);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hopitale_edit', array('id' => $hopitale->getId()));
        }

        return $this->render('hopitale/edit.html.twig', array(
            'hopitale' => $hopitale,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hopitale entity.
     *
     * @Route("/delete/{id}", name="hopitale_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Hopitale $hopitale)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($hopitale);
        $em->flush($hopitale);


        return $this->redirectToRoute('hopitale_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/activer/{id}", name="hopitale_activer")
     * @Method("GET")
     */
    public function activerAction(Request $request, Hopitale $hopitale)
    {

        $userId = $hopitale->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '1' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('hopitale_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/deactiver/{id}", name="hopitale_deactiver")
     * @Method("GET")
     */
    public function deactiverAction(Request $request, Hopitale $hopitale)
    {

        $userId = $hopitale->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '0' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('hopitale_index');
    }

    /**
     * Creates a form to delete a hopitale entity.
     *
     * @param Hopitale $hopitale The hopitale entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hopitale $hopitale)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hopitale_delete', array('id' => $hopitale->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }


    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="hopitale_contact")
     * @Method({"GET"})
     */
    public function contactAction(Hopitale $medecin)
    {

        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $medecin->getUser()->getId()));

        $text = array();
        if (!is_null($messageEntity))
            $text = json_decode($messageEntity->getText(), true);

//dump($text);die;
        return $this->render('hopitale/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="hopitale_contact_post")
     * @Method({"POST"})
     */
    public function contactPostAction(Hopitale $medecin, Request $request)
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


        return $this->render('hopitale/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }



}
