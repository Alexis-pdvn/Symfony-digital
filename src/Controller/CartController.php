<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Carrier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        $carrier = $this->entityManager->getRepository(Carrier::class)->findAll();

        return $this->render('cart/index.html.twig', [
            'carrier' => $carrier,
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/cart/add/", name="add_to_cart")
     */
    public function add(Cart $cart, Request $request): Response
    {
        $idproduit = $request->get('id_produit');
        $idsize = $request->get('id_size');
        $cart->add($idproduit, $idsize);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove/", name="remove_my_cart")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('products');
    }

    /**
     * @Route("/cart/delete/", name="delete_to_cart")
     */
    public function delete(Cart $cart, Request $request): Response
    {
        $idproduit = $request->get('id_produit');
        $idsize = $request->get('id_size');

        $cart->delete($idproduit, $idsize);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/", name="decrease_to_add")
     */
    public function decrease(Cart $cart, Request $request): Response
    {
        $idproduit = $request->get('id_produit');
        $idsize = $request->get('id_size');
        $cart->decrease($idproduit, $idsize);

        return $this->redirectToRoute('cart');
    }
}
