<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/category/{name}", name="category")
     */
    public function index($name): Response
    {
        
        $products = $this->entityManager->getRepository(Product::class)->findByisBest(1);
        $cat = $this->entityManager->getRepository(Category::class)->findOneBy(array('name' => $name));

        if (!$cat) {
            return $this->redirectToRoute('products');
        }

        $product_cat = $cat->getProducts()->toArray();

        return $this->render('category/index.html.twig', [
            'cat' => $cat,
            'products' => $products,
            'product_cat' => $product_cat
        ]);
    }

    public function Category()
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render(
            'category/category_nav.html.twig',
            ['category' => $category]
        );
    }
    
    public function CategoryHome()
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render(
            'category/category_home.html.twig',
            ['category' => $category]
        );
    }

}
