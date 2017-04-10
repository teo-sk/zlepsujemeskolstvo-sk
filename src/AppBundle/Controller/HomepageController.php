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

        //fetch categories
        $categories = $em->getRepository('AppBundle:Category')
            ->createQueryBuilder('c')
            ->where('c.parent IS NOT NULL')
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getResult();

        //fetch count
        $count = $em->getRepository('AppBundle:Suggestion')->createQueryBuilder('s')
            ->select('COUNT(s)')
            ->where('s.approved = :bool')
            ->setParameter('bool', true)
            ->getQuery()
            ->useQueryCache(true)
            ->useResultCache(true)
            ->getSingleScalarResult();


        //show view
        return $this->render('AppBundle:homepage:index.html.twig', array(
            'form' => $form->createView(),
            'showThanks' => !$showForm,
            'mailingForm' => $this->mailingForm->createView(),
            'categories' => $categories,
            'showMailingForm' => $this->showMailingForm,
            'count' => $count
        ));
    }
}
