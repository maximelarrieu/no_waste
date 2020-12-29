<?php

namespace App\Controller;

use App\Entity\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart/{id}", name="cart")
     */
    public function index(Cart $cart): Response
    {
        $user = $this->getUser();



        return $this->render('cart/index.html.twig', [
            'user' => $this->getUser(),
            'commodities' => $cart->getCommodity()
        ]);
    }
}
