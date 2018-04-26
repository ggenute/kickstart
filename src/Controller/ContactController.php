<?php

namespace App\Controller;

use App\Birthday\AgeCalculation;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     * @param Request        $request
     * @param AgeCalculation $ageCalculation
     * @return Response
     */
    public function index(Request $request, AgeCalculation $ageCalculation): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        $result = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
//            dump($contactFormData);

            $myBirthday = $contactFormData['dateOfBirth']->format('Y-m-d');
            $age = $ageCalculation->howOldIAm($myBirthday);
            $adult = $ageCalculation->amIAnAdult($age) ? ' an adult' : 'a kid';

            $result = sprintf('I am %s years old and I am %s ', $age, $adult) ;
        }
        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView(),
            'resultText' => $result
        ]);
    }
}
