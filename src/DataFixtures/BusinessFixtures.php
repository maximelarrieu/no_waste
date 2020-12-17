<?php

namespace App\DataFixtures;

use App\Entity\Business;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BusinessFixtures extends Fixture implements DependentFixtureInterface
{
    const BUSINESS_COUNT = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($b = 0; $b < self::BUSINESS_COUNT; $b++) {
            $business = new Business();
            $business->setName($faker->company);
            $business->setAddress($faker->address);
            $business->setDescription($faker->text);
            $business->setPhoneNumber('0500000000');
            $business->setUser($this->getReference('user'.random_int(0, UserFixtures::USER_COUNT - 1)));
            for($c = 0; $c < random_int(0, 6); $c++) {
                $business->addCommodity($this->getReference('commodity'.random_int(0, CommodityFixtures::COMMODITY_COUNT -1)));
            }
            $manager->persist($business);
        }

        $manager->flush();

    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CommodityFixtures::class,
        ];
    }
}
