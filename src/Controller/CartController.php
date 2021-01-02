<?php

namespace App\Controller;

use App\Repository\CommodityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(SessionInterface $session, CommodityRepository $commodityRepository)
    {
        $cart = $cart = $session->get('cart', []);

        $cartWithData = [];

        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'commodity' => $commodityRepository->find($id),
                'quantity' => $quantity
            ];
        }

        $total = 0;

        foreach ($cartWithData as $item) {
            $totalItem = $item['commodity']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig', [
            'items' => $cartWithData,
            'total' => $total
        ]);
    }

    //Méthode d'ajout d'article(s) au panier (cart=panier).
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session) 
    {
        $cart = $session->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);

       return $this->redirectToRoute("cart_index");
    }

    //Méthode de suppression d'article au panier (cart=panier).
    /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session) 
    {
        $cart = $session->get('cart', []);

        if($cart[$id] >= 2) {
            $cart[$id]--;
        }else {
            unset($cart[$id]);
        }
        $session->set('cart', $cart);

        return $this->redirectToRoute("cart_index");
    }
}