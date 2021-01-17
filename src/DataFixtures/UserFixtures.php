<?php

namespace App\DataFixtures;

use App\Entity\Cart;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USER_COUNT = 20;
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder) {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $password = $this->userPasswordEncoder->encodePassword(new User(), 'password');
        $adminpaswword = $this->userPasswordEncoder->encodePassword(new User(), 'admin');

        for($u = 0; $u < self::USER_COUNT; $u++) {
            $cart = new Cart();
            $user = new User();
            $user->setEmail($faker->email);
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setBalance(50.00);
            $user->setPassword($password);
            $user->setCreatedAt($faker->dateTime);
            $user->setCart($cart);
            $this->addReference('user'.$u, $user);
            $manager->persist($user);
        }

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setFirstname('the');
        $admin->setLastname('admin');
        $admin->setBalance(2000.00);
        $admin->setPassword($adminpaswword);
        $admin->setCreatedAt(new \DateTime());
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $manager->flush();
    }
}
