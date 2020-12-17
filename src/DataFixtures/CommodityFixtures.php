<?php

namespace App\DataFixtures;

use App\Entity\Commodity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommodityFixtures extends Fixture
{
    const COMMODITY_COUNT = 30;
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($c = 0; $c < self::COMMODITY_COUNT; $c++) {
            $commodity = new Commodity();
            $commodity->setTitle($faker->title);
            $commodity->setDescription($faker->text);
            $commodity->setPrice($faker->randomFloat(2, 4, 12));
            $commodity->setRemaining($faker->numberBetween(1, 7));
            $this->addReference('commodity'.$c, $commodity);
            $manager->persist($commodity);
        }

        $manager->flush();
    }
}
