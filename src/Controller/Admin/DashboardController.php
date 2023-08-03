<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\Clients;
use App\Entity\Enseignes;
use App\Entity\Produits;
use App\Entity\References;
use App\Entity\Users;
use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ProduitsCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        
        return Dashboard::new()
            ->setTitle('My Project');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        MenuItem::section('Users');
        yield MenuItem::linkToCrud('Users', 'fa fa-user', Users::class);

        MenuItem::section('Produits');
        yield MenuItem::linkToCrud('Produits', 'fa fa-tag', Produits::class);

        MenuItem::section('Enseignes');
        yield MenuItem::linkToCrud('Enseignes', 'fa fa-shop', Enseignes::class);

        MenuItem::section('Références');
        yield MenuItem::linkToCrud('References', 'fa fa-barcode', References::class);

        MenuItem::section('Catégories');
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Categories::class);

        MenuItem::section('Clients');
        yield MenuItem::linkToCrud('Clients', 'fa fa-users', Clients::class);


        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', UsersCrudController::class);
    }
}
