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

        $order = (in_array($request->query->get('order'), ['newest', 'popular'])) ? $request->query->get('order') : 'popular';

        $this->handleMailingForm($request);
        if ($this->redirect) {
            return $this->redirectToRoute('category', array('id' => $id));
        }

        //fetch category
        $category = $em->getRepository('AppBundle:Category')
            ->findOneById($id);

        if (!$category) {
            throw $this->createNotFoundException('Kategória neexistuje.');
        }

        if ('popular' == $order) {
            $suggestions = $category->getPopularSuggestions();
        } else {
            $suggestions = $category->getAllSuggestions();
        }

        //show view
        return $this->render('AppBundle:category:category.html.twig', array(
            'mailingForm' => $this->mailingForm->createView(),
            'showMailingForm' => $this->showMailingForm,
            'category' => $category,
            'suggestions' => $suggestions,
            'order' => $order
        ));
    }
}