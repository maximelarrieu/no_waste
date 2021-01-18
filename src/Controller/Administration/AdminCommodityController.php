<?php

namespace App\Controller\Administration;

use App\Entity\Business;
use App\Entity\Commodity;
use App\Form\CommodityType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommodityController extends AbstractController
{
    /**
     * @Route("admin/business/{slug}/commodity/add", name="admin_commodity_add")
     * @Route("admin/business/{slug}/commodity/edit/{id}", name="admin_commodity_edit")
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

        return $this->render('admin/commodity/form.html.twig', [
            'form' => $commodityForm->createView(),
            'commodity' => $commodity
        ]);
    }

    /**
     * @Route("admin/commodity/remove/{id}", name="admin_commodity_remove")
     */
    public function remove(Commodity $commodity, EntityManagerInterface $manager): Response {
        $manager->remove($commodity);
        $manager->flush();

        return $this->redirectToRoute('admin_business');
    }
}
