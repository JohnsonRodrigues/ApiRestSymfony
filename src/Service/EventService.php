<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;
use DateTime;
use Symfony\Component\Uid\Ulid;

class EventService
{
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function findAll(): array
    {
        return $this->eventRepository->findAll();
    }

    public function findById(string $id): ?Event
    {
        return $this->eventRepository->find(Ulid::fromString($id));
    }

    public function create(array $attributes): ?Event
    {
        $event = new Event();
        $event->setTitle($attributes['title']);
        $event->setDescription($attributes['description']);
        $event->setStart(new DateTime($attributes['start']));
        $event->setEnd(new DateTime($attributes['end']));
        $event->setStatus($attributes['status']);
        return $this->eventRepository->create($event);
    }

    public function update(string $id, array $attributes): ?Event
    {
        $event = $this->findById($id);
        $event->setTitle($attributes['title']);
        $event->setDescription($attributes['description']);
        $event->setStart(new DateTime($attributes['start']));
        $event->setEnd(new DateTime($attributes['end']));
        $event->setStatus($attributes['status']);
        return $this->eventRepository->update($event);
    }

    public function delete(string $id): void
    {
        $event = $this->findById($id);
        $this->eventRepository->delete($event);
    }


}