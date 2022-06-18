<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="about_my_work_banner")
 */
final class AboutMyWorkBanner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false, options={"unsigned"=true})
     */
    private int $id;
    /**
     * @ORM\Column(name="path", type="string", nullable="false", length=255)
     */
    private string $path;

    /**
     * @ORM\Column(name="active", type="boolean", options={"default"="true"})
     */
    private bool $active = true;

    /**
     * @ORM\Column(name="created_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
