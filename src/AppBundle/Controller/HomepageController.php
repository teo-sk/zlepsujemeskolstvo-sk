<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\SuggestionType;
use AppBundle\Form\MailingType;
use AppBundle\Entity\Suggestion;
use AppBundle\Entity\Mailing;

class HomepageController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //handle suggestion
        $suggestion = new Suggestion();
        $form = $this->createForm(SuggestionType::class, $suggestion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $suggestion->setIp($request->getClientIp());

            $em->persist($suggestion);
            $em->flush();

            $this->addFlash(
                        'form',
                        'thanks'
                    );
            return $this->redirectToRoute('homepage');
        }
        $flash = $this->get('session')->getFlashBag()->get('form');
        $showForm = !(!empty($flash) && $flash[0] === 'thanks');

        $this->handleMailingForm($request);
        if ($this->redirect) {
            return $this->redirectToRoute('homepage');
        }

        //load shortlist of newest suggestions
        $repo = $em->getRepository('AppBundle:Suggestion');
        $query = $repo->createQueryBuilder('s')
            ->where('s.approved = :bool')
            ->setParameter('bool', true)
            ->orderBy('s.created', 'DESC')
            ->setMaxResults(6)
            ->getQuery();
        $suggestions = $query->getResult();

        //fetch count
        $count = $repo->createQueryBuilder('s')
            ->select('COUNT(s)')
            ->where('s.approved = :bool')
            ->setParameter('bool', true)
            ->getQuery()
            ->getSingleScalarResult();


        //show view
        return $this->render('AppBundle:homepage:index.html.twig', array(
            'form' => $form->createView(),
            'showForm' => $showForm,
            'mailingForm' => $this->mailingForm->createView(),
            'showMailingForm' => $this->showMailingForm,
            'suggestions' => $suggestions,
            'count' => $count
        ));
    }
}
