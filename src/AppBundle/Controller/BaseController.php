<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\MailingType;
use AppBundle\Entity\Mailing;

class BaseController extends Controller
{
    protected $showMailingForm = true;
    protected $redirect = false;
    protected $mailingForm;

    /**
     * @return boolean Redirect to current route
     */
    protected function handleMailingForm($request)
    {
        //handle newsletter submit
        $mailing = new Mailing();
        $em = $this->getDoctrine()->getManager();
        $this->mailingForm = $this->createForm(MailingType::class, $mailing);
        $this->mailingForm->handleRequest($request);
        if ($this->mailingForm->isSubmitted() && $this->mailingForm->isValid()) {
            $mailing->setIp($request->getClientIp());

            $em->persist($mailing);
            $em->flush();

            $this->addFlash(
                        'mailingForm',
                        'thanks'
                    );
            $this->redirect = true;
            return;
        }
        $flash = $this->get('session')->getFlashBag()->get('mailingForm');
        $this->showMailingForm = !(!empty($flash) && $flash[0] === 'thanks');
    }
}