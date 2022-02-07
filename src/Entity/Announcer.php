<?php

namespace App\Entity;

use App\Repository\AnnouncerRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;

/**
 * @ORM\Entity(repositoryClass=AnnouncerRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Announcer implements JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    private Ulid $id;

    /**
     * @ORM\ManyToOne(targetEntity=Lecture::class, inversedBy="announcers")
     * @ORM\JoinColumn(name="lecture_id", referencedColumnName="id")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Lecture $lecture;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private string $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeInterface $updatedAt;


    public function getId(): Ulid
    {
        return $this->id;
    }

    public function setId(Ulid $id): void
    {
        $this->id = $id;
    }

    public function getLecture(): ?Lecture
    {
        return $this->lecture;
    }

    public function setLecture(?Lecture $lecture): void
    {
        $this->lecture = $lecture;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
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
            'name' => $this->getName(),
            'lecture' => $this->getLecture() ? $this->getLecture()->getId() : null,
            'created_at' => $this->getCreatedAt()->format('d/m/Y h:m:s'),
            'updated_at' => $this->getUpdatedAt()->format('d/m/Y h:m:s'),
        ];
    }
}
