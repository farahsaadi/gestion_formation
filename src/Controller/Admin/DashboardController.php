<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ApprenantCrudController;
use App\Entity\Apprenant;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Formation;
use App\Controller\Admin\FormationCrudController;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Session;
use App\Entity\User;
use App\Controller\Admin\SessionCrudController;
use App\Controller\Admin\UserCrudController;
use App\Controller\ReportController;



///#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // 1.1) If you have enabled the "pretty URLs" feature:
         //return $this->redirectToRoute('report_apprenants');
        //
        // 1.2) Same example but using the "ugly URLs" that were used in previous EasyAdmin versions:
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(ApprenantCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


public function index2(): Response
{
$routeBuilder = $this->container->get(AdminUrlGenerator::class);
$url = $routeBuilder->setController(FormationCrudController::class)->generateUrl();
return $this->redirect($url);
// return parent::index();
}
public function index3(): Response
{
$routeBuilder = $this->container->get(AdminUrlGenerator::class);
$url = $routeBuilder->setController(SessionCrudController::class)->generateUrl();
return $this->redirect($url);
// return parent::index();
}
public function index4(): Response
{
$routeBuilder = $this->container->get(AdminUrlGenerator::class);
$url = $routeBuilder->setController(UserCrudController::class)->generateUrl();
return $this->redirect($url);
// return parent::index();
}


    public function configureDashboard(): Dashboard
    {
       return Dashboard::new()

       ->setTitle('<img src="assets/s.jpg" class="img-fluid d-block mx-auto" style="max-width:100px; width:100%;"><h2 class="mt-3 fw-bold text-white text-center">Gestion_des_formation</h2>')
       ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Apprenant', 'fas fa-chalkboard-teacher',Apprenant::class);
        yield MenuItem::linkToCrud('Formation', 'fas fa-chalkboard-teacher',Formation::class);
        yield MenuItem::linkToCrud('Session', 'fas fa-chalkboard-teacher',Session::class);
        yield MenuItem::linkToCrud('User', 'fas fa-chalkboard-teacher',User::class);
         yield MenuItem::linkToRoute('Statistiques Apprenants', 'fas fa-chart-bar', 'report_apprenants');
    }
}
