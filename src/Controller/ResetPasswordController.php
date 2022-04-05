<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));

            if ($user) {
                $resetpwd = new ResetPassword();
                $resetpwd->setUser($user);
                $resetpwd->setToken(uniqid());
                $resetpwd->setCreatedAt(new \DateTime());
                $this->entityManager->persist($resetpwd);
                $this->entityManager->flush();

                // Envoyer d'emai pour la maj de pwd

                $url = $this->generateUrl('update_password', [
                    'token' => $resetpwd->getToken()
                ]);

                $content = "Bonjour ".$user->getFirstname()."<br> Vous avez demandé a réinitialiser votre mot de passe<br><br>";
                $content .= "Cliquer sur <a href=".$url.">ce lien</a>";

                $mail = new Mail();
                $mail->send($user->getEmail(), $user->getFirstname().' '.$user->getLastname(), 'Réinitialier votre mot de passe', $content);

                $this->addFlash('notice', 'Un mail vous sera envoyer prochainement.');
            }else{
                $this->addFlash('notice', 'Cette adresse email est inconnue.');
            }
        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/mot-de-passe-oublie/{token}", name="update_password")
     */
    public function update(Request $request, $token, UserPasswordEncoderInterface $encoder): Response
    {
        $resetpwd = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$resetpwd) {
            return $this->redirectToRoute('reset_password');
        }

        // Vérifier si le createdAt = now - 1h
        $now = new \DateTime();
        if ($now > $resetpwd->getCreatedAt()->modify('+ 1 hour')) {
            $this->addFlash('notice', 'Votre demande a expirée.');
            return $this->redirectToRoute('reset_password');
        }

        //Rendre une vue avec mot de passe et confirmation
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $new_pwd = $form->get('new_password')->getData();

            //Encodr le mot de passe
            $password = $encoder->encodePassword($resetpwd->getUser(), $new_pwd);
            $resetpwd->getUser()->setPassword($password);

            // Flush en base de donnée
            $this->entityManager->flush();

            // Redirection de l'utilisateur
            $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
