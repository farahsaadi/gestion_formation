<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/admin/report/apprenants', name: 'admin_report_apprenants')]
    public function apprenants(): Response
    {
        return $this->render('admin/report/apprenants.html.twig');
    }
}
