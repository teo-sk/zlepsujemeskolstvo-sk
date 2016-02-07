<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use AppBundle\Entity\Vote;

class AjaxController extends Controller
{
    /**
     * @Route("/api/vote/{id}", name="vote")
     */
    public function voteAction(Request $request, $id)
    {
        $isAjax = $request->isXmlHttpRequest();

        if (!$isAjax) {
            return $this->redirectToRoute('homepage');
        }

        try {
            $em = $this->getDoctrine()->getManager();

            $suggestion = $em->getRepository('AppBundle:Suggestion')
                ->findOneById($id);
            if (!$suggestion) {
                return new JsonResponse(array('error' => 'Tento podnet neexistuje.'), 404);
            }

            $vote = new Vote();

            $vote->setIp($request->getClientIp());
            $vote->setFingerprint($request->get('fingerprint'));
            $vote->setSuggestion($suggestion);

            $cookie = $request->cookies->get('vote-' . $id);
            if (!$cookie) {
                $generator = new SecureRandom();
                $random = $generator->nextBytes(10);
                $cookie = new Cookie('vote-' . $id, $random);
                $vote->setCookie($cookie);
            } else {
                return new JsonResponse(array('error' => 'Za tento podnet ste už hlasoval.'), 409);
            }

            $em->persist($vote);
            $em->flush();

            $response = new JsonResponse(array('msg' => 'ok'));
            $response->headers->setCookie($cookie);
            return $response;
        } catch (UniqueConstraintViolationException $e) {
            return new JsonResponse(array('error' => 'Za tento podnet ste už hlasoval.'), 409);
        }
    }
}