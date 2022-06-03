<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{

    // Appellation du manager DOCTRINE poux utiliser la base de donnée

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response // Encoder les mots de passe grâce a UserPasswordEncoderInterface
    {

        $notification = null;

        $user = new User(); // Création d'un nouvel utilisateur (un objet)
        $form = $this->createForm(RegisterType::class, $user); // Création du formulaire souhaiter dans mon cas RegisterType, et on lui passe l'objet

        $form->handleRequest($request);  // Demander au formulaire d'écouter la request

        if($form->isSubmitted() && $form->isValid()){ // Si le formulaire a était soumit et valide (valide en fonction de Type renseigner dans le RegisterType)

            $user = $form->getData(); // Injecter dans l'object user toutes les données du formulaire

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail()); // Nous cherchons si l'email existe déja ou non

            if (!$search_email) { // Si l'email n'existe pas alors on crée le compte

                $password = $encoder->encodePassword($user, $user->getPassword()); // Encodage du mot de passe
                $user->setPassword($password); // Met a jour le mot de passe encoder

                $this->entityManager->persist($user); // Fige les données
                $this->entityManager->flush(); // Enregister les données figer en Base de données

                $mail = new Mail();
                $content = "Bonjour ".$user->getFirstname()."<br/>Bienvenue sur notre boutique";
                $mail->send($user->getEmail(), $user->getFirstname(),'Bienvenue chez AVAMAE', $content);

                $notification = "Votre inscription s'est correctement déroulée. Vous pouvez vous connecter";
                
            } else { // Si l'email existe déja alors on envoie un message d'erreur

                $notification = "L'email que vous avez renseigné existe déjà ";
            }

        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView(), // Ici nous passons le formulaire en variable au template tout en créant la vue de celui ci
            'notification' => $notification
        ]);
    }
}
