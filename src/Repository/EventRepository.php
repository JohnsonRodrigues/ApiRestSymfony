<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function create(Event $event): ?Event
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
        return $event;
    }


    public function update(Event $event): ?Event
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
        return $event;
    }

    public function delete(Event $event): void
    {
        $this->getEntityManager()->remove($event);
        $this->getEntityManager()->flush();
    }
}
