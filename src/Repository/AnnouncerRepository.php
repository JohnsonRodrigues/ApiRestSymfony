<?php

namespace App\Repository;

use App\Entity\Announcer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AnnouncerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcer::class);
    }

    public function create(Announcer $announcer): ?Announcer
    {
        $this->getEntityManager()->persist($announcer);
        $this->getEntityManager()->flush();
        return $announcer;
    }

    public function update(Announcer $announcer): ?Announcer
    {
        $this->getEntityManager()->persist($announcer);
        $this->getEntityManager()->flush();
        return $announcer;
    }

    public function delete(Announcer $announcer): void
    {
        $this->getEntityManager()->remove($announcer);
        $this->getEntityManager()->flush();
    }
}
