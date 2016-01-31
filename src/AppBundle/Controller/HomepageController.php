<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SuggestionType;
use AppBundle\Entity\Suggestion;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $suggestion = new Suggestion();
        $form = $this->createForm(SuggestionType::class, $suggestion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $suggestion->setIp($request->getClientIp());

            $em = $this->getDoctrine()->getManager();
            $em->persist($suggestion);
            $em->flush();

            return $this->redirectToRoute('homepage', array('form' => 'thanks'));
        }

        $showForm = ($request->query->get('form') === 'thanks');
        return $this->render('AppBundle:homepage:index.html.twig', array(
            'form' => $form->createView(),
            'showForm' => !$showForm
        ));
    }
}
