<?php

namespace App\Controller;

use App\Entity\Business;
use App\Form\BusinessFormType;
use App\Repository\BusinessRepository;
use App\Repository\CommodityRepository;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BusinessController extends AbstractController
{
    /**
     * @Route("/business", name="business")
     */
    public function index(BusinessRepository $businessRepository): Response
    {
        $business = $businessRepository->findAll();
        return $this->render('business/index.html.twig', [
            'business' => $business,
        ]);
    }

    /**
     * @Route("business/add", name="business_add")
     * @Route("business/edit/{id}", name="business_edit")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY') and (business == null or business.getUser() == user)")
     */
    public function businessForm(Request $request, EntityManagerInterface $manager, Business $business = null): Response {

        $slugify = new Slugify();

        if($business === null) {
            $business = new Business();
        }

        $businessForm = $this->createForm(BusinessFormType::class, $business);
        $businessForm->handleRequest($request);

        if($businessForm->isSubmitted() && $businessForm->isValid()) {
            if(! $business->getId()) {
                $business->setUser($this->getUser());
            }
            $business->setSlug($slugify->slugify($business->getName()));
            $manager->persist($business);
            $manager->flush();
            return $this->redirectToRoute('profile');
        }

        return $this->render('business/form.html.twig', [
            'form' => $businessForm->createView(),
            'business' => $business
        ]);
    }


    /**
     * @Route("business/{id}", name="business_detail")
     */
    public function details(Business $business = null, CommodityRepository $commodityRepository): Response {
       $commodities = $commodityRepository->getCommoditiesByBusiness($business);
        return $this->render('business/details.html.twig', [
            'business' => $business,
            'commodities' => $commodities
        ]);
    }

    /**
     * @Route("/business/remove/{id}", name="business_remove")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY') and (business == null or business.getUser() == user)")
     */
    public function remove(Business $business, EntityManagerInterface $manager): Response {
        $manager->remove($business);
        $manager->flush();

        return $this->redirectToRoute('profile');
    }
}
