<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Form\ApprenantType;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/apprenant')]
final class ApprenantController extends AbstractController
{
    #[Route(name: 'app_apprenant_index', methods: ['GET'])]
    public function index(ApprenantRepository $apprenantRepository): Response
    {
        return $this->render('apprenant/index.html.twig', [
            'apprenants' => $apprenantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_apprenant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $apprenant = new Apprenant();
        $form = $this->createForm(ApprenantType::class, $apprenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($apprenant);
            $entityManager->flush();

            return $this->redirectToRoute('app_apprenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('apprenant/new.html.twig', [
            'apprenant' => $apprenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apprenant_show', methods: ['GET'])]
    public function show(Apprenant $apprenant): Response
    {
        return $this->render('apprenant/show.html.twig', [
            'apprenant' => $apprenant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apprenant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apprenant $apprenant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ApprenantType::class, $apprenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_apprenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('apprenant/edit.html.twig', [
            'apprenant' => $apprenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apprenant_delete', methods: ['POST'])]
    public function delete(Request $request, Apprenant $apprenant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apprenant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($apprenant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_apprenant_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
