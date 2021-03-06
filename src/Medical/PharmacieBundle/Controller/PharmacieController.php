<?php

namespace Medical\PharmacieBundle\Controller;

use Medical\MedecinBundle\Entity\Message;
use Medical\PharmacieBundle\Entity\Pharmacie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pharmacie controller.
 *
 * @Route("pharmacie")
 */
class PharmacieController extends Controller
{
    /**
     * Lists all pharmacie entities.
     *
     * @Route("/", name="pharmacie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pharmacies = $em->getRepository('PharmacieBundle:Pharmacie')->findAll();

        return $this->render('pharmacie/index.html.twig', array(
            'pharmacies' => $pharmacies,
        ));
    }

    /**
     * Creates a new pharmacie entity.
     *
     * @Route("/new", name="pharmacie_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pharmacie = new Pharmacie();
        $form = $this->createForm('Medical\PharmacieBundle\Form\PharmacieType', $pharmacie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $pharmacie->getUser();
            $user->addRole('ROLE_PHARMACIE')->setEnabled(true);
            $pharmacie->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($pharmacie);
            $em->flush($pharmacie);

            return $this->redirectToRoute('pharmacie_show', array('id' => $pharmacie->getId()));
        }

        return $this->render('pharmacie/new.html.twig', array(
            'pharmacie' => $pharmacie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pharmacie entity.
     *
     * @Route("/{id}", name="pharmacie_show")
     * @Method("GET")
     */
    public function showAction(Pharmacie $pharmacie)
    {
        $deleteForm = $this->createDeleteForm($pharmacie);

        $img = $pharmacie->getImage();
        $var= explode('web',$img);
        $pharmacie->setImage('http://localhost/siwar_pfe/web'.$var[1]);

        return $this->render('pharmacie/show.html.twig', array(
            'pharmacie' => $pharmacie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pharmacie entity.
     *
     * @Route("/{id}/edit", name="pharmacie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pharmacie $pharmacie)
    {
        $deleteForm = $this->createDeleteForm($pharmacie);
        $editForm = $this->createForm('Medical\PharmacieBundle\Form\PharmacieType', $pharmacie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pharmacie_edit', array('id' => $pharmacie->getId()));
        }

        return $this->render('pharmacie/edit.html.twig', array(
            'pharmacie' => $pharmacie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pharmacie entity.
     *
     * @Route("/delete/{id}", name="pharmacie_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, Pharmacie $pharmacie)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($pharmacie);
            $em->flush($pharmacie);


        return $this->redirectToRoute('pharmacie_index');
    }



    /**
     * Deletes a hopitale entity.
     *
     * @Route("/activer/{id}", name="pharmacie_activer")
     * @Method("GET")
     */
    public function activerAction(Request $request, Pharmacie $pharmacie)
    {

        $userId = $pharmacie->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '1' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('pharmacie_index');
    }


    /**
     * Deletes a hopitale entity.
     *
     * @Route("/deactiver/{id}", name="pharmacie_deactiver")
     * @Method("GET")
     */
    public function deactiverAction(Request $request, Pharmacie $pharmacie)
    {

        $userId = $pharmacie->getUser()->getId();

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "UPDATE `user` SET `enabled` = '0' WHERE `id` = $userId ;";

        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        return $this->redirectToRoute('pharmacie_index');
    }


    /**
     * Creates a form to delete a pharmacie entity.
     *
     * @param Pharmacie $pharmacie The pharmacie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pharmacie $pharmacie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pharmacie_delete', array('id' => $pharmacie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="pharmacie_contact")
     * @Method({"GET"})
     */
    public function contactAction(Pharmacie $medecin)
    {

        $messageEntity = $this->get('doctrine.orm.entity_manager')->getRepository(Message::class)->findOneBy(array('idUser' => $medecin->getUser()->getId()));

        $text = array();
        if (!is_null($messageEntity))
            $text = json_decode($messageEntity->getText(), true);

//dump($text);die;
        return $this->render('pharmacie/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }

    /**
     * Lists all medecin entities.
     *
     * @Route("/contact/{id}", name="pharmacie_contact_post")
     * @Method({"POST"})
     */
    public function contactPostAction(Pharmacie $medecin, Request $request)
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


        return $this->render('pharmacie/contact.html.twig', array(
            'medecin' => $medecin,
            'text' => $text
        ));
    }

}
