<?php

namespace App\Service;

use App\Repository\CommodityRepository;
use Symfony\Component\Form\Exception\OutOfBoundsException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;




class CartService 
{

    protected $session;
    protected $CommodityRepository;

    public function __construct(SessionInterface $session, CommodityRepository $commodityRepository)
    {
        $this->session = $session;
        
        $this->commodityRepository = $commodityRepository;
    }
    
    public function add(int $id)
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])) {
            $cart[$id]++;
        }else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function remove($id)
    {
        $cart = $this->session->get('cart', []);

        if($cart[$id] >= 2) {
            $cart[$id]--;
        }else {
            unset($cart[$id]);
        }
        $this->session->set('cart', $cart);
    }

    public function entireCart(): array
    {
        $cart = $this->session->get('cart', []);

        $cartWithData = [];

        foreach($cart as $id => $quantity) {
            $cartWithData[] = [
                'commodity' => $this->commodityRepository->find($id),
                'quantity' => $quantity
            ];
        }
        return $cartWithData;
    }

    public function total(): float
    {
        $total = 0.00;

        foreach ($this->entireCart() as $item) {
            floatval($total += $item['commodity']->getPrice() * $item['quantity']);
        }

        return floatval($total);
    }

    public function removeAll()
    {
        $idRef = 0;
        $cart = $this->session->get('cart', []);


        foreach ($this->entireCart() as $item) {
            $idRef = $item['commodity']->getId();
            unset($cart[$idRef]);
        }
        $this->session->set('cart', $cart);
    }

}