<?php

namespace App\Controller\Administration;

use App\Entity\Business;
use App\Form\AdminBusinessFormType;
use App\Form\BusinessFormType;
use App\Repository\BusinessRepository;
use App\Repository\CommodityRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminBusinessController extends AbstractController
{
    /**
     * @Route("/admin/business", name="admin_business")
     */
    public function index(BusinessRepository $businessRepository): Response
    {
        $businesses = $businessRepository->findAll();
        return $this->render('admin/business/index.html.twig', [
            'business' => $businesses
        ]);
    }

    /**
     * @Route("admin/business/add", name="admin_business_add")
     * @Route("admin/business/edit/{id}", name="admin_business_edit")
     */
    public function businessForm(Request $request, EntityManagerInterface $manager, Business $business = null): Response {

        $slugify = new Slugify();

        if($business === null) {
            $business = new Business();
        }

        $businessForm = $this->createForm(AdminBusinessFormType::class, $business);
        $businessForm->handleRequest($request);

        if($businessForm->isSubmitted() && $businessForm->isValid()) {
            $business->setSlug($slugify->slugify($business->getName()));
            $manager->persist($business);
            $manager->flush();
            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/business/form.html.twig', [
            'form' => $businessForm->createView(),
            'business' => $business
        ]);
    }

    /**
     * @Route("/admin/business/{id}", name="admin_business_details")
     */
    public function details(CommodityRepository $commodityRepository, Business $business) {
        $commodities = $commodityRepository->getCommoditiesByBusiness($business);
        return $this->render("admin/business/details.html.twig", [
            'commodities' => $commodities,
            'business' => $business
        ]);
    }


    /**
     * @Route("admin/business/remove/{id}", name="admin_business_remove")
     */
    public function remove(Business $business, EntityManagerInterface $manager): Response {
        $manager->remove($business);
        $manager->flush();

        return $this->redirectToRoute('admin_business');
    }
}
