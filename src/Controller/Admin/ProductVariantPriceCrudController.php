<?php

namespace App\Controller\Admin;

use App\Entity\ProductVariantPrice;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductVariantPriceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVariantPrice::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('size'),
            MoneyField::new('price')->setCurrency('EUR'),
        ];
    }
}
