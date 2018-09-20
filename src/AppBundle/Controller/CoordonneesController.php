<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Coordonnees;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Coordonnee controller.
 *
 * @Route("coordonnees")
 */
class CoordonneesController extends Controller
{
    /**
     * Lists all coordonnee entities.
     *
     * @Route("/", name="prefix_new_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $coordonnees = $em->getRepository('AppBundle:Coordonnees')->findAll();

        return $this->render('coordonnees/index.html.twig', array(
            'coordonnees' => $coordonnees,
        ));
    }

    /**
     * Creates a new coordonnee entity.
     *
     * @Route("/new", name="prefix_new_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $coordonnee = new Coordonnees();
        $form = $this->createForm('AppBundle\Form\CoordonneesType', $coordonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coordonnee);
            $em->flush();

            return $this->redirectToRoute('prefix_new_show', array('id' => $coordonnee->getId()));
        }

        return $this->render('coordonnees/new.html.twig', array(
            'coordonnee' => $coordonnee,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a coordonnee entity.
     *
     * @Route("/{id}", name="prefix_new_show")
     * @Method("GET")
     */
    public function showAction(Coordonnees $coordonnee)
    {
        $deleteForm = $this->createDeleteForm($coordonnee);

        return $this->render('coordonnees/show.html.twig', array(
            'coordonnee' => $coordonnee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing coordonnee entity.
     *
     * @Route("/{id}/edit", name="prefix_new_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Coordonnees $coordonnee)
    {
        $deleteForm = $this->createDeleteForm($coordonnee);
        $editForm = $this->createForm('AppBundle\Form\CoordonneesType', $coordonnee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('prefix_new_edit', array('id' => $coordonnee->getId()));
        }

        return $this->render('coordonnees/edit.html.twig', array(
            'coordonnee' => $coordonnee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a coordonnee entity.
     *
     * @Route("/{id}", name="prefix_new_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Coordonnees $coordonnee)
    {
        $form = $this->createDeleteForm($coordonnee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($coordonnee);
            $em->flush();
        }

        return $this->redirectToRoute('prefix_new_index');
    }

    /**
     * Creates a form to delete a coordonnee entity.
     *
     * @param Coordonnees $coordonnee The coordonnee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Coordonnees $coordonnee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('prefix_new_delete', array('id' => $coordonnee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
