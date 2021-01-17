<?php

namespace App\Controller\Administration;

use App\Service\StatsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param StatsService $service
     * @return Response
     */
    public function index(StatsService $service): Response
    {
        $stats = $service->getStats();
        return $this->render('admin/index.html.twig', [
            'stats' => $stats,
        ]);
    }

    public function navbar(): Response {
        $user = $this->getUser();

        return $this->render('admin/navbar.html.twig', [
            'user' => $user
        ]);
    }
}
