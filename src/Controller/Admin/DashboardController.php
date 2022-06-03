<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Header;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Entity\Variant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Avamae');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);

        yield MenuItem::section('E-commerce');
        yield MenuItem::subMenu('Produits', 'fas fa-tag')->setSubItems([
            MenuItem::linkToCrud('Nos Produits', 'fas fa-eye', Product::class),
            MenuItem::linkToCrud('Ajouter un Produit', 'fas fa-plus', Product::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Categories', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Nos Categories', 'fas fa-eye', Category::class),
            MenuItem::linkToCrud('Ajouter une Categories', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
        ]);
        
        yield MenuItem::linkToCrud('Tailles', 'fas fa-ruler', Variant::class);
        yield MenuItem::linkToCrud('Transporteur', 'fas fa-truck', Carrier::class);
        yield MenuItem::linkToCrud('Nos Commandes', 'fas fa-shopping-cart', Order::class);

        yield MenuItem::section('Apparence');
        yield MenuItem::linkToCrud('Carrousel', 'fas fa-desktop', Header::class);
    }
}
