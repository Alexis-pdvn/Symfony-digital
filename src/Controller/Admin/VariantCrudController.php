<?php

namespace App\Controller\Admin;

use App\Entity\Variant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VariantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Variant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('size'),
            MoneyField::new('price')->setCurrency('EUR'),
        ];
    }
}
