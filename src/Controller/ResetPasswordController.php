<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/forgot-password', name: 'reset_password')]
    public function index(Request $request): Response
    {
        // 1️⃣ Redirection si utilisateur déjà connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('home'); // modifie si besoin
        }

        // 2️⃣ ICI EXACTEMENT : Vérifier si le formulaire est soumis
        if ($request->get('email')) {

            // On récupère l'email envoyé
            $email = $request->get('email');

            // 3️⃣ ICI EXACTEMENT : Vérifier si l'utilisateur existe
            $user = $this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['email' => $email]); 
                // ⚠️ Change 'email' si ton champ est username

            // 4️⃣ Test → afficher le résultat
            dd($user);
        }

        // 3️⃣ Affichage du formulaire
        return $this->render('reset_password/index.html.twig');
    }
}
