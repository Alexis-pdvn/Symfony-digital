<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{

    public $entitymanager;

    public function __construct(EntityManagerInterface $entitymanager)
    {
        $this->entitymanager = $entitymanager;
    }

    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart, Request $request): Response
    {

        if (!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_add_address');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"post"})
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $date = new \DateTime();
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= "<br/>".$delivery->getPhone();

            if ($delivery->getCompany())
            {
                $delivery_content .= "<br/>".$delivery->getCompany();
            }

            $delivery_content .= "<br/>".$delivery->getAddress()." ".$delivery->getPostal().','.$delivery->getCity()." - ".$delivery->getCountry();

            // Enregistrer ma commandes Order()
            $order = new Order();
            $reference = $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->entitymanager->persist($order);

            // Enregistrer mes commandes Orderdetails()
            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['size']->getPrice());
                $orderDetails->setTotal($product['size']->getPrice() * $product['quantity']);
                $orderDetails->setSize($product['size']->getSize());
                $this->entitymanager->persist($orderDetails);
            }

            $this->entitymanager->flush();

            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference(),
            ]);

        }

        return $this->redirectToRoute('cart');

    }
}
