<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('cart/index.html.twig', [
            'items' => $cartService->entireCart(),
            'total' => $cartService->total()
        ]);
    }

    //Méthode d'ajout d'article(s) au panier (cart=panier).
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService) 
    {
        $cartService->add($id);

       return $this->redirectToRoute("cart_index");
    }

    //Méthode de suppression d'article au panier (cart=panier).
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService) 
    {
        $cartService->remove($id);

        return $this->redirectToRoute("cart_index");
    }
}