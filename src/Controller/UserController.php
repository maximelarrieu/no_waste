<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
        $commands = $user->getCommands();

        if ( ! $user) {
            return $this->redirectToRoute('login');
        }

        return $this->render('user/index.html.twig', [
            'user' => $user,
            'business' => $business,
            'commands' => $commands
        ]);
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/profile/update", name="user_edit")
     */
    public function edit(Request $request, EntityManagerInterface $manager) {

        /** @var UserInterface $user */
        $user = $this->getUser();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('user/form.html.twig', [
            'form' => $userForm->createView(),
            'user' => $user
        ]);
    }
}
