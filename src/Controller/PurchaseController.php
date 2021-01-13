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
     * fonction qui permet la validation du panier
     * @Route("/cart/purchase/buy/{id}", name="purchase_buy")
     */
    public function buy($id, PurchaseService $purchaseService, \Swift_Mailer $mailer, CartService $cartService, UserRepository $userRepository)
    {
       $reponse = $purchaseService->BuyConfirm($id);
       $user = $userRepository->find($id);

        if ($reponse == 1) {
            $message = (new \Swift_Message('Merci pour votre commande !'))
                ->setFrom('nowaste33800@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/index.html.twig',
                        [
                        'items' => $cartService->entireCart(),
                        'total' => $cartService->total()
                        ]
                    ), 'text/html')
                ;

            $mailer->send($message);

            $cartService->removeAll();

            return $this->redirectToRoute("purchase_index");
        } else {
            return $this->render('Purchase/errorBuy.html.twig', []);
        }
        
    }
}