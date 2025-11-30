<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('plainPassword')->getData();
            $agreeTerms = $form->get('agreeTerms')->getData();

            if (!$plainPassword || strlen($plainPassword) < 6) {
                $this->addFlash('error', 'Le mot de passe doit contenir au moins 6 caractères');
                return $this->render('registration/register.html.twig', ['registrationForm' => $form]);
            }

            if (!$agreeTerms) {
                $this->addFlash('error', 'Vous devez accepter les conditions d\'utilisation');
                return $this->render('registration/register.html.twig', ['registrationForm' => $form]);
            }

            // Symfony remplira automatiquement l'email depuis le formulaire
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été créé avec succès !');
            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', ['registrationForm' => $form]);
    }
}
