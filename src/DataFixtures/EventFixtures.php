<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Lecture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture
{
    public const QUANTITY = 10;
    public const STATUS = array('Agendado', 'Acontecendo', 'Finalizado', 'Cancelado');

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::QUANTITY; $i++) {
            $event = new Event();
            $event->setTitle("Title " . $i);
            $event->setDescription("Description " . $i);
            $event->setStart(new DateTimeImmutable('now'));
            $event->setEnd(new DateTimeImmutable('now'));
            $event->setStatus(self::STATUS[array_rand(self::STATUS, 1)]);

            $lecture = new Lecture();
            $lecture->setTitle("Title " . $i);
            $lecture->setDescription("Description " . $i);
            $lecture->setDate(new DateTimeImmutable('now'));
            $lecture->setStartTime(new DateTimeImmutable('now'));
            $lecture->setEndTime(new DateTimeImmutable('now'));
            $event->addLecture($lecture);
            $this->setReference("event-{$i}", $event);
            $manager->persist($event);
        }
        $manager->flush();
    }
}
