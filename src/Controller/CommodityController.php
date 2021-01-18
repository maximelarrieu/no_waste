<?php

namespace App\Controller;

use App\Entity\Business;
use App\Entity\Cart;
use App\Entity\Commodity;
use App\Form\BuyCommodityType;
use App\Form\CommodityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class CommodityController extends AbstractController
{
    /**
     * @Route("/commodity/{id}", name="commodity")
     * @param Commodity $commodity
     * @return Response
     */
    public function index(Commodity $commodity, Request $request, EntityManagerInterface $manager): Response
    {

        $commodityForm = $this->createForm(BuyCommodityType::class, $commodity);
        $commodityForm->handleRequest($request);

        return $this->render('commodity/index.html.twig', [
            'commodity' => $commodity,
            'form' => $commodityForm->createView()
        ]);
    }

    /**
     * @Route("/commodity/{id}/add", name="add_to_cart")
     */
    public function addToCart(Commodity $commodity) {
        $user = $this->getUser();
        $cart = $user->getCart();

        $cart->addCommodity($commodity);

        return $this->redirectToRoute('cart', [
            'id' => $cart->getId()
        ]);

    }

    /**
     * @Route("business/{slug}/commodity/add", name="commodity_add")
     * @Route("business/{slug}/commodity/edit/{id}", name="commodity_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function commodityForm(Request $request, EntityManagerInterface $manager, Business $business = null, Commodity $commodity = null): Response {
        if($commodity === null) {
            $commodity = new Commodity();
        }

        $commodityForm = $this->createForm(CommodityType::class, $commodity);
        $commodityForm->handleRequest($request);

        if($commodityForm->isSubmitted() && $commodityForm->isValid()) {
            if (! $commodity->getId()) {
                $commodity->addBusiness($business);
            }
            $manager->persist($commodity);
            $manager->flush();
            return $this->redirectToRoute('business_detail', [
                'id' => $business->getId()
            ]);
        }

        return $this->render('commodity/form.html.twig', [
            'form' => $commodityForm->createView(),
            'commodity' => $commodity
        ]);
    }

    /**
     * @Route("commodity/remove/{id}", name="commodity_remove")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function remove(Commodity $commodity, EntityManagerInterface $manager): Response {

        $manager->remove($commodity);
        $manager->flush();

        return $this->redirectToRoute('profile');
    }
}
