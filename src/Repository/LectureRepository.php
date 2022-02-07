<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Lecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class LectureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lecture::class);
    }

    public function create(Lecture $lecture): ?Lecture
    {
        $this->getEntityManager()->persist($lecture);
        $this->getEntityManager()->flush();
        return $lecture;
    }

    public function update(Lecture $lecture): ?Lecture
    {
        $this->getEntityManager()->persist($lecture);
        $this->getEntityManager()->flush();
        return $lecture;
    }

    public function delete(Lecture $lecture): void
    {
        $this->getEntityManager()->remove($lecture);
        $this->getEntityManager()->flush();
    }
}
