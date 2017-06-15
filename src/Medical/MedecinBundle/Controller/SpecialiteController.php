<?php

namespace Medical\MedecinBundle\Controller;

use Medical\MedecinBundle\Entity\Specialite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Specialite controller.
 *
 * @Route("specialite")
 */
class SpecialiteController extends Controller
{
    /**
     * Lists all specialite entities.
     *
     * @Route("/", name="specialite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $specialites = $em->getRepository('MedecinBundle:Specialite')->findAll();

        return $this->render('specialite/index.html.twig', array(
            'specialites' => $specialites,
        ));
    }

    /**
     * Creates a new specialite entity.
     *
     * @Route("/new", name="specialite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $specialite = new Specialite();
        $form = $this->createForm('Medical\MedecinBundle\Form\SpecialiteType', $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($specialite);
            $em->flush();

            return $this->redirectToRoute('specialite_index');
        }

        return $this->render('specialite/new.html.twig', array(
            'specialite' => $specialite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a specialite entity.
     *
     * @Route("/{id}", name="specialite_show")
     * @Method("GET")
     */
    public function showAction(Specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);

        return $this->render('specialite/show.html.twig', array(
            'specialite' => $specialite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing specialite entity.
     *
     * @Route("/{id}/edit", name="specialite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Specialite $specialite)
    {
        $deleteForm = $this->createDeleteForm($specialite);
        $editForm = $this->createForm('Medical\MedecinBundle\Form\SpecialiteType', $specialite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialite_edit', array('id' => $specialite->getId()));
        }

        return $this->render('specialite/edit.html.twig', array(
            'specialite' => $specialite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a specialite entity.
     *
     * @Route("/delete/{id}", name="specialite_delete")
     * @Method("Get")
     */
    public function deleteAction(Request $request, Specialite $specialite)
    {

            $em = $this->getDoctrine()->getManager();
            $em->remove($specialite);
            $em->flush();


        return $this->redirectToRoute('specialite_index');
    }

    /**
     * Creates a form to delete a specialite entity.
     *
     * @param Specialite $specialite The specialite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Specialite $specialite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specialite_delete', array('id' => $specialite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
