<?php

namespace Medical\HopitaleBundle\Controller;

use Medical\HopitaleBundle\Entity\Hopitale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
        $var= explode('web',$img);
        $hopitale->setImage('http://localhost/siwar_pfe/web'.$var[1]);

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
     * @Route("/{id}", name="hopitale_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Hopitale $hopitale)
    {
        $form = $this->createDeleteForm($hopitale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($hopitale);
            $em->flush($hopitale);
        }

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
            ->getForm()
        ;
    }
}
