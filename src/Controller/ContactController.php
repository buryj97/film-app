<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
                ->from($contactFormData['email'])
                ->to('buryj15@gmail.com')
                ->subject('You got mail')
                ->text('Sender : '.$contactFormData['email'].\PHP_EOL.
                    $contactFormData['message'],
                    'text/plain');
                    
            $mailer->send($message);




            $this->addFlash('success', 'Your message has been sent');

            return $this->redirectToRoute('app_contact');
        }



        return $this->render('contact/index.html.twig', [
            'our_form' => $form->createView()
        ]);
    }
    
}