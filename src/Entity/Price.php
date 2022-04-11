<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PriceRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceRepository::class)
 */
final class Price
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false, unique=true, options={"unsigned"=true})
     */
    private int $id;

    /**
     * @ORM\Column(name="content_title", type="string", nullable=true, length=255, options={"default"=""})
     */
    private string $contentTitle;

    /**
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private string $content;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"=true})
     */
    private bool $active;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentTitle(): string
    {
        return $this->contentTitle;
    }

    public function setContentTitle(string $contentTitle): void
    {
        $this->contentTitle = $contentTitle;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
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
