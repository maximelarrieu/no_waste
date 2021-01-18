<?php

namespace App\Controller\Administration;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'AdminUserController',
        ]);
    }
}
