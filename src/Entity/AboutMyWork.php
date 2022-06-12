<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\AboutMyWorkRepository")
 * @ORM\Table(name="about_my_work")
 */
class AboutMyWork
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false, options={"unsigned"=true})
     */
    private int $id;

    /**
     * @ORM\Column(name="title", type="string", nullable=true, length=255)
     */
    private ?string $title = null;

    /**
     * @ORM\Column(name="content", type="blob", nullable=false)
     */
    private string $content;

    /**
     * @ORM\Column(name="image", type="string", nullable=false)
     */
    private string $image;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false)
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

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
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
