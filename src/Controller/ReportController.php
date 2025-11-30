<?php

namespace App\Controller;

use App\Entity\FormationSearch;
use App\Form\FormationSearchType;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ApprenantRepository;
use App\templates\report;
use Symfony\Component\HttpFoundation\Response;


final class ReportController extends AbstractController
{
    #[Route('/report/by-formation', name: 'report_by_formation')]
    public function byFormation(Request $request, SessionRepository $repository)
    {
        $search = new FormationSearch();
        $form = $this->createForm(FormationSearchType::class, $search);
        $form->handleRequest($request);

        $sessions = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $formation = $search->getFormation();
            if ($formation) {
                $sessions = $repository->findBy(['formation' => $formation]);
            } else {
                $sessions = $repository->findAll();
            }
        }

        return $this->render('report/by_formation.html.twig', [
            'form' => $form->createView(),
            'sessions' => $sessions
        ]);
    }
     #[Route('/report/apprenants', name: 'report_apprenants')]
public function apprenants(ApprenantRepository $repo): Response
{
    $stats = $repo->countApprenantsByFormation();

    return $this->render('report/apprenants.html.twig', [
        'stats' => $stats,
    ]);
}

}
