<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ImageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false, options={"unsigned"=true})
     */
    private int $id;

    /**
     * @ORM\Column(name="image", type="string", nullable=false, length=255)
     */
    private string $image;

    /**
     * @ORM\Column(name="name_crc32", type="integer", nullable=false, options={"unsigned"=true})
     */
    private int $nameCrc32;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"=true})
     */
    private bool $active;

    /**
     * @ORM\Column(name="width", type="string", length=25, nullable=false, columnDefinition="ENUM('50','100')")
     */
    private string $width = '50';

    /**
     * @ORM\Column(name="weight", type="integer", length=11, nullable=false, options={"default"= 0})
     */
    private int $weight = 0;

    /**
     * @ORM\Column(name="description", type="string", nullable=true, length=255, options={"default"=""})
     */
    private ?string $description;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $updatedAt;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getNameCrc32(): int
    {
        return $this->nameCrc32;
    }

    public function setNameCrc32(int $nameCrc32): void
    {
        $this->nameCrc32 = $nameCrc32;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
