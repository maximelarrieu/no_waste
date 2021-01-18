<?php

namespace App\Controller;

use App\Entity\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandController extends AbstractController
{
    /**
     * @Route("/command/{id}", name="command")
     */
    public function index(Command $command): Response
    {
        return $this->render('command/index.html.twig', [
            'command' => $command,
        ]);
    }
}
