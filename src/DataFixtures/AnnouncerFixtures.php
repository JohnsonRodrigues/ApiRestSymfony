<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Announcer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnnouncerFixtures extends Fixture implements DependentFixtureInterface
{
    public const QUANTITY = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= self::QUANTITY; $i++) {
            $announcer = new Announcer();
            $announcer->setName("Name " . $i);
            $announcer->setLecture($this->getReference('lecture-1'));
            $manager->persist($announcer);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LectureFixtures::class,
        ];
    }
}
