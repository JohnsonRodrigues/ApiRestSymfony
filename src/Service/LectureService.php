<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Entity\Lecture;
use App\Repository\LectureRepository;
use DateTime;
use Symfony\Component\Uid\Ulid;

class LectureService
{
    private LectureRepository $lectureRepository;
    private EventService $eventService;

    public function __construct(LectureRepository $lectureRepository,EventService $eventService)
    {
        $this->lectureRepository = $lectureRepository;
        $this->eventService = $eventService;
    }

    public function findAll(): array
    {
        return $this->lectureRepository->findAll();
    }

    public function findById(string $id): ?Lecture
    {
        return $this->lectureRepository->find(Ulid::fromString($id));
    }

    public function create(array $attributes): ?Lecture
    {
        $lecture = new Lecture();
        $event  = $this->eventService->findById($attributes['event_id']);
        $lecture->setTitle($attributes['title']);
        $lecture->setDescription($attributes['description']);
        $lecture->setDate(new DateTime($attributes['date']));
        $lecture->setStartTime(new DateTime($attributes['start_time']));
        $lecture->setEndTime(new DateTime($attributes['end_time']));
        $lecture->setEvent($event);
        $lecture->setAnnouncer($attributes['announcer']);
        return $this->lectureRepository->create($lecture);
    }

    public function update(string $id, array $attributes): ?Lecture
    {
        $lecture = $this->findById($id);
        $lecture->setTitle($attributes['title']);
        $lecture->setDescription($attributes['description']);
        $lecture->setDate(new DateTime($attributes['date']));
        $lecture->setStartTime(new DateTime($attributes['start_time']));
        $lecture->setEndTime(new DateTime($attributes['end_time']));
        $lecture->setAnnouncer($attributes['announcer']);
        return $this->lectureRepository->update($lecture);
    }

    public function delete(string $id): void
    {
        $lecture = $this->findById($id);
        $this->lectureRepository->delete($lecture);
    }


}