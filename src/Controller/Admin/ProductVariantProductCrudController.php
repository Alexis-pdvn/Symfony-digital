<?php

namespace App\Controller\Admin;

use App\Entity\ProductVariantProduct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class ProductVariantProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductVariantProduct::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('productVariant')
        ];
    }
}
