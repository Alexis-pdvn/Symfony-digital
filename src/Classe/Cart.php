<?php

namespace App\Classe;


use App\Entity\Product;
use App\Entity\Variant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id, $productVariantion)
    {
        $cart = $this->session->get('cart', []);
        if (!empty($cart[$id.'_'.$productVariantion])) {
            $cart[$id.'_'.$productVariantion]++;
        }else{
            $cart[$id.'_'.$productVariantion] = 1;
        }
        $this->session->set('cart', $cart);

    }

    public function get()
    {
        return $this->session->get('cart');
    }

    public function remove()
    {
        return $this->session->remove('cart');
    }

    public function delete($id, $productVariantion)
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id.'_'.$productVariantion]);

        return $this->session->set('cart', $cart);
    }

    public function decrease($id, $productVariantion)
    {
        $cart = $this->session->get('cart', []);

        if ($cart[$id.'_'.$productVariantion] > 1){
            $cart[$id.'_'.$productVariantion]--;
        }else{
            unset($cart[$id.'_'.$productVariantion]);
        }

        return $this->session->set('cart', $cart);

    }

    public function getFull()
    {
        $cartComplete = [];

        if ($this->get()){
            foreach ($this->get() as $id => $quantity){
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById(explode('_', $id)[0]);
                $size = $this->entityManager->getRepository(Variant::class)->findOneById(explode('_', $id)[1]);

                if(!$product_object){
                    $this->delete($id);
                    continue;
                }

                $cartComplete[] = [
                    'product' => $product_object,
                    'size' => $size,
                    'quantity' => $quantity
                ];
            }
        }

        return $cartComplete;
    }

}