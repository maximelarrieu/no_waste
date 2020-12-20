<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @Route("/user/{id}", name="user_profile")
     */
    public function index(User $user = null): Response
    {
        $user ??= $this->getUser();
        $business = $user->getBusiness();

        if ( ! $user) {
            return $this->redirectToRoute('login');
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'business' => $business,
            'controller_name' => 'UserController',
        ]);
    }
}
