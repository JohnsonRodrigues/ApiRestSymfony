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
    public const QUANTITY = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::QUANTITY; $i++) {
            $lecture = new Lecture();
            $lecture->setTitle("Title " . $i);
            $lecture->setDescription("Description " . $i);
            $lecture->setDate(new DateTimeImmutable('now'));
            $lecture->setStartTime(new DateTimeImmutable('now'));
            $lecture->setEndTime(new DateTimeImmutable('now'));
            $lecture->setEvent($this->getReference('event-1'));
            $this->setReference("lecture-{$i}", $lecture);
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
