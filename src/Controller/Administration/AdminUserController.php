<?php

namespace App\Controller\Administration;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommandRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/{id}/commands", name="admin_user_commands")
     */
    public function commands(User $user, CommandRepository $commandRepository) {
        $commands = $commandRepository->getCommandsByUser($user);

        return $this->render('admin/user/commands.html.twig', [
            'commands' => $commands,
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function edit(User $user, Request $request, EntityManagerInterface $manager) {

        /** @var UserInterface $user */
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if($userForm->isSubmitted() && $userForm->isValid()) {
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/form.html.twig', [
            'form' => $userForm->createView(),
            'user' => $user
        ]);
    }
    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     */
    public function remove(User $user, EntityManagerInterface $manager) {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_user');
    }
}
