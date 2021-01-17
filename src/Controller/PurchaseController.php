<?php

namespace App\Controller;

use App\Entity\Command;
use App\Repository\UserRepository;
use App\Service\CartService;
use App\Service\PurchaseService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;


class PurchaseController extends AbstractController
{
    private $emailVerifier;

//    public function __construct(EmailVerifier $emailVerifier)
//    {
//        $this->emailVerifier = $emailVerifier;
//    }

    /**
     * @Route("/cart/purchase", name="purchase_index")
     */
    public function index(CartService $cartService)
    {
        return $this->render('Purchase/index.html.twig', [
            'total' => $cartService->total()
        ]);
    }
    
    /**
     * fonction qui permet la validation du panier
     * @Route("/cart/purchase/buy/{id}", name="purchase_buy")
     */
    public function buy($id, PurchaseService $purchaseService, \Swift_Mailer $mailer, CartService $cartService, UserRepository $userRepository, Request $request, EntityManagerInterface $manager): \Symfony\Component\HttpFoundation\Response
    {
       $reponse = $purchaseService->BuyConfirm($id);
       $items = $cartService->entireCart();
       $user = $userRepository->find($id);

        if ($reponse == 1) {
            $message = (new \Swift_Message('Merci pour votre commande !'))
                ->setFrom('nowaste33800@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'email/index.html.twig',
                        [
                        'items' => $cartService->entireCart(),
                        'total' => $cartService->total()
                        ]
                    ), 'text/html')
                ;

            $mailer->send($message);

            $command = new Command();

            foreach ($items as $item) {
                $command->addCommodity($item['commodity']);
                $command->setNbCommand(rand(1000, 3000));
                $command->setCreatedAt(new \DateTime());
                $command->setUser($user);
                $command->setTotal($cartService->total());
                $manager->persist($command);
            }
            $manager->flush();
            $cartService->removeAll();

            return $this->redirectToRoute("purchase_index");
        } else {
            return $this->render('Purchase/errorBuy.html.twig', []);
        }
        
    }
}