<?php

namespace App\Controller;

use App\Entity\Business;
use App\Repository\BusinessRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BusinessController extends AbstractController
{
    /**
     * @Route("/business", name="business")
     */
    public function index(BusinessRepository $businessRepository): Response
    {
        $business = $businessRepository->findAll();
        return $this->render('business/index.html.twig', [
            'business' => $business,
        ]);
    }

    /**
     * @Route("/business/{id}", name="business_detail")
     */
    public function details(Business $business): Response {
        return $this->render('business/details.html.twig', [
            'business' => $business
        ]);
    }
}
