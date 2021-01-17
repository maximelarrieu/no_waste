<?php

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;


class StatsService {
    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    public function getStats() {
        $users = $this->getUsers();
        $recents_users = $this->getRecentsUsers();
        $commands = $this->getCommands();
        $recents_commands = $this->getRecentsCommands();
        $totaux = $this->getTotaux();
        $recents_totaux = $this->getRecentsTotaux();

        return compact('users', 'recents_users', 'commands', 'recents_commands', 'totaux', 'recents_totaux');
    }

    public function getUsers() {
        return $this->manager->createQuery("SELECT COUNT(u) FROM App\Entity\User u")->getSingleScalarResult();
    }

    public function getRecentsUsers() {
        return $this->manager->createQuery(
            "SELECT COUNT(u)
                FROM App\Entity\User u
                WHERE u.createdAt > :lastdays
                "
        )
            ->setParameter('lastdays', new \DateTime('- 7 days'))
            ->getSingleScalarResult();
    }

    public function getCommands() {
        return $this->manager->createQuery(
            "SELECT COUNT(c) FROM App\Entity\Command c"
        )->getSingleScalarResult();
    }

    public function getRecentsCommands() {
        return $this->manager->createQuery(
            "SELECT COUNT(c)
                FROM App\Entity\Command c
                WHERE c.createdAt > :lastdays
                "
        )
            ->setParameter('lastdays', new \DateTime('- 7 days'))
            ->getSingleScalarResult();
    }

    public function getTotaux() {
        return $this->manager->createQuery(
            "SELECT SUM(c.total)
                FROM App\Entity\Command c
            "
        )->getSingleScalarResult();
    }

    public function getRecentsTotaux() {
        return $this->manager->createQuery(
            "SELECT SUM(c.total)
                FROM App\Entity\Command c
                WHERE c.createdAt > :lastdays
                "
        )
            ->setParameter('lastdays', new \DateTime('- 7 days'))
            ->getSingleScalarResult();
    }
}