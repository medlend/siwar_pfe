<?php

namespace Medical\LaboratoireBundle\Controller;

use Medical\LaboratoireBundle\Entity\Laboratoire;
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
     * @Route("/{id}", name="laboratoire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Laboratoire $laboratoire)
    {
        $form = $this->createDeleteForm($laboratoire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($laboratoire);
            $em->flush($laboratoire);
        }

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
}
