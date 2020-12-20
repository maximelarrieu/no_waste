<?php

namespace App\Controller;

use App\Repository\CommodityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CommodityRepository $commodityRepository): Response
    {
        $commodities = $commodityRepository->findAll();
        return $this->render('home/index.html.twig', [
            'commodities' => $commodities
        ]);
    }

    public function navbar(): Response {
        $user = $this->getUser();

        return $this->render('navbar.html.twig', [
            'user' => $user
        ]);
    }
}
