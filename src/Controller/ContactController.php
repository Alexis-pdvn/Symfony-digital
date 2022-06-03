<?php

namespace App\Controller;

use App\Classe\MailContact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'merci de nous avoir contacté....');

            $mail = new MailContact();
            $prenom = $form->get('prenom')->getData();
            $nom = $form->get('nom')->getData();
            $nom = $form->get('number')->getData();
            $email = $form->get('email')->getData();
            $nom = $form->get('objet')->getData();
            $content = $form->get('content')->getData();
            $mail->send('avamae.projet@gmail.com','AVAMAE','Demande de contact', $prenom, $nom, $email, $content,);
        }

        return $this->render('contact/index.html.twig',[
                'form' => $form->createView()
        ]);
    }
}
