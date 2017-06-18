<?php

namespace Medical\LaboratoireBundle\Controller;

use Medical\LaboratoireBundle\Entity\Laboratoire;
use Medical\MedecinBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Laboratoire controller.
 *
 * @Route("laboratoire")
 */
class LaboratoireController extends Controller
{
    /**
     * Lists all laboratoire entities.
     *
     * @Route("/", name="laboratoire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $laboratoires = $em->getRepository('LaboratoireBundle:Laboratoire')->findAll();

        return $this->render('laboratoire/index.html.twig', array(
            'laboratoires' => $laboratoires,
        ));
    }

    /**
     * Creates a new laboratoire entity.
     *
     * @Route("/new", name="laboratoire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $laboratoire = new Laboratoire();
        $form = $this->createForm('Medical\LaboratoireBundle\Form\LaboratoireType', $laboratoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $laboratoire->getUser();
            $user->addRole('ROLE_LABORATOIRE')->setEnabled(true);
            $laboratoire->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($laboratoire);
            $em->flush($laboratoire);

            return $this->redirectToRoute('laboratoire_show', array('id' => $laboratoire->getId()));
        }

        return $this->render('laboratoire/new.html.twig', array(
            'laboratoire' => $laboratoire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a laboratoire entity.
     *
     * @Route("/{id}", name="laboratoire_show")
     * @Method("GET")
     */
    public function showAction(Laboratoire $laboratoire)
    {
        $deleteForm = $this->createDeleteForm($laboratoire);

        $img = $laboratoire->getImage();
        $var= explode('web',$img);
        $laboratoire->setImage('http://localhost/siwar_pfe/web'.$var[1]);

        return $this->render('laboratoire/show.html.twig', array(
            'laboratoire' => $laboratoire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing laboratoire entity.
     *
     * @Route("/{id}/edit", name="laboratoire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Laboratoire $laboratoire)
    {
        $deleteForm = $this->createDeleteForm($laboratoire);
        $editForm = $this->createForm('Medical\LaboratoireBundle\Form\LaboratoireType', $laboratoire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('laboratoire_edit', array('id' => $laboratoire->getId()));
        }

        return $this->render('laboratoire/edit.html.twig', array(
            'laboratoire' => $laboratoire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a laboratoire entity.
     *
     * @Route("/laboratoire/{id}", name="laboratoire_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Laboratoire $laboratoire)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($laboratoire);
            $em->flush($laboratoire);


        return $this->redirectToRoute('laboratoire_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/activer/{id}", name="laboratoire_activer")
     * @Method("GET")
     */
    public function activerAction(Request $request, Laboratoire $laboratoire)
    {

        $userId = $laboratoire->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '1' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('laboratoire_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/deactiver/{id}", name="laboratoire_deactiver")
     * @Method("GET")
     */
    public function deactiverAction(Request $request, Laboratoire $laboratoire)
    {

        $userId = $laboratoire->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '0' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('laboratoire_index');
    }


    /**
     * Creates a form to delete a laboratoire entity.
     *
     * @param Laboratoire $laboratoire The laboratoire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Laboratoire $laboratoire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('laboratoire_delete', array('id' => $laboratoire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="laboratoire_contact")
     * @Method({"GET"})
     */
    public function contactAction(Laboratoire $medecin)
    {

        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $medecin->getUser()->getId()));

        $text = array();
        if (!is_null($messageEntity))
            $text = json_decode($messageEntity->getText(), true);

//dump($text);die;
        return $this->render('laboratoire/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="laboratoire_contact_post")
     * @Method({"POST"})
     */
    public function contactPostAction(Laboratoire $medecin, Request $request)
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


        return $this->render('laboratoire/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }



}
