<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Announcer;
use App\Repository\AnnouncerRepository;
use Symfony\Component\Uid\Ulid;

class AnnouncerService
{
    private AnnouncerRepository $announcerRepository;
    private LectureService $lectureService;

    public function __construct(AnnouncerRepository $announcerRepository, LectureService $lectureService)
    {
        $this->announcerRepository = $announcerRepository;
        $this->lectureService = $lectureService;
    }

    public function findAll(): array
    {
        return $this->announcerRepository->findAll();
    }

    public function findById(string $id): ?Announcer
    {
        return $this->announcerRepository->find(Ulid::fromString($id));
    }

    public function create(array $attributes): ?Announcer
    {
        $lecture = $this->lectureService->findById($attributes['lecture_id']);
        $announcer = new Announcer();
        $announcer->setName($attributes['name']);
        $announcer->setLecture($lecture);
        return $this->announcerRepository->create($announcer);
    }

    public function update(string $id, array $attributes): ?Announcer
    {
        $lecture = $this->lectureService->findById($attributes['lecture_id']);
        $announcer = $this->findById($id);
        $announcer->setName($attributes['name']);
        $announcer->setLecture($lecture);
        return $this->announcerRepository->update($announcer);
    }

    public function delete(string $id): void
    {
        $announcer = $this->findById($id);
        $this->announcerRepository->delete($announcer);
    }


}