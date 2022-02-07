<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Lecture;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LectureFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUANTITY = 20;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::QUANTITY; $i++) {
            $lecture = new Lecture();
            $lecture->setTitle("Title " . $i);
            $lecture->setDescription("Description " . $i);
            $lecture->setAnnouncer("Announcer " . $i);
            $lecture->setDate(new DateTimeImmutable('now'));
            $lecture->setStartTime(new DateTimeImmutable('now'));
            $lecture->setEndTime(new DateTimeImmutable('now'));
            $this->getReference('event-1');
            $manager->persist($lecture);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EventFixtures::class,
        ];
    }
}
