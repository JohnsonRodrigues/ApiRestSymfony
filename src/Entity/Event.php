<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\EventRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    private Ulid $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private string $title;

    /**
     * @ORM\Column(type="text")
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $end;

    /**
     * @ORM\Column(type="string", length=100, columnDefinition="enum('Agendado', 'Acontecendo', 'Finalizado', 'Cancelado')")
     */
    private string $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $updatedAt;


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

    public function getId(): Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): void
    {
        $this->id = $id;
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

    public function getStart(): DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(DateTimeInterface $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(DateTimeInterface $end): void
    {
        $this->end = $end;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
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
}
