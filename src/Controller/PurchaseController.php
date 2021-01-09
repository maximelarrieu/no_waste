<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\CartService;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PurchaseController extends AbstractController
{
    /**
     * @Route("/cart/purchase", name="purchase_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('Purchase/index.html.twig', [
            'total' => $cartService->total()
        ]);
    }
    
    /**
     * @Route("/cart/purchase/buy/{id}", name="purchase_buy")
     */
    public function buy($id, PurchaseService $purchaseService)
    {
       $reponse = $purchaseService->BuyConfirm($id);

        if ($reponse == 1) {
            return $this->redirectToRoute("purchase_index");
        } else {
            return $this->render('Purchase/errorBuy.html.twig', []);
        }
        
    }
}