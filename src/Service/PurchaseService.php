<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;


class PurchaseService 
{
    protected $cartService;
    
    protected $userRepository;

    protected $em;

    public function __construct(UserRepository $userRepository, CartService $cartService, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        
        $this->cartService = $cartService;

        $this->em = $em;
    }
    
    public function errorBuy()
    {
        
    }

    public function BuyConfirm($id)
    {
        $user = $this->userRepository->find($id);
        
        $soldeActuel = $user->getBalance();
        
        $total = $this->cartService->total();

        $reponse = 0;
        
        if ($soldeActuel>$total) {
        
            $user->setBalance($soldeActuel-floatval($total));
             
            $this->em->persist($user);

            $this->em->flush();
        
            $this->cartService->removeAll();

            $reponse = 1;
        
        }

        return $reponse;
             
    }
}