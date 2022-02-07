<?php

namespace App\Entity;

use App\Repository\LectureRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity(repositoryClass=LectureRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Lecture implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    private Ulid $id;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="lectures")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=false)
     */
    private Event $event;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="date")
     */
    private DateTimeInterface $date;

    /**
     * @ORM\Column(type="time")
     */
    private DateTimeInterface $startTime;

    /**
     * @ORM\Column(type="time")
     */
    private DateTimeInterface $endTime;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $updatedAt;


    /**
     * @ORM\OneToMany(targetEntity=Announcer::class, mappedBy="lecture",orphanRemoval=true, cascade={"persist"})
     */
    private Collection $announcers;

    public function __construct()
    {
        $this->announcers = new ArrayCollection();
    }

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): void
    {
        $this->id = $id;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(DateTimeInterface $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(DateTimeInterface $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getAnnouncers(): Collection
    {
        return $this->announcers;
    }

    public function setAnnouncers($announcers): void
    {
        $this->announcers = $announcers;
    }

    public function addAnnouncer(Announcer $announcer): self
    {
        if (!$this->announcers->contains($announcer)) {
            $this->announcers[] = $announcer;
            $announcer->setLecture($this);
        }

        return $this;
    }

    public function removeAnnouncer(Announcer $announcer): self
    {
        if ($this->announcers->removeElement($announcer)) {
            if ($announcer->getLecture() === $this) {
                $announcer->setLecture(null);
            }
        }

        return $this;
    }


    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setCreatedAt(new DateTimeImmutable('now'));
        $this->setUpdatedAt(new DateTimeImmutable('now'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->setUpdatedAt(new DateTimeImmutable('now'));
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'announcers' => $this->getAnnouncers(),
            'event_id' => $this->getEvent()->getId(),
            'date' => $this->getDate()->format('d/m/Y h:m:s'),
            'start_time' => $this->getStartTime()->format('h:m:s'),
            'end_time' => $this->getEndTime()->format('h:m:s'),
            'created_at' => $this->getCreatedAt()->format('d/m/Y h:m:s'),
            'updated_at' => $this->getUpdatedAt()->format('d/m/Y h:m:s'),
        ];
    }


}
