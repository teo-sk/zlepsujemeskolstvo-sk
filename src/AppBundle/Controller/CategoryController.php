<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends BaseController
{
    /**
     * @Route("/kategoria/{id}", name="category")
     */
    public function categoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $this->handleMailingForm($request);
        if ($this->redirect) {
            return $this->redirectToRoute('category', array('id' => $id));
        }

        //fetch category
        $category = $em->getRepository('AppBundle:Category')
            ->findOneById($id);

        //show view
        return $this->render('AppBundle:category:category.html.twig', array(
            'mailingForm' => $this->mailingForm->createView(),
            'showMailingForm' => $this->showMailingForm,
            'category' => $category,
        ));
    }
}