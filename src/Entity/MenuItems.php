<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="menu_items")
 *
 */
class MenuItems
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false, options={"unsigned"=true})
     */
    private int $id;

    /**
     * @ORM\Column(name="item_name", type="string", nullable=false, length=255)
     */
    private string $itemName;

    /**
     * @ORM\Column(name="item_link", type="string", nullable=false, length=255)
     */
    private string $itemLink;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"=true})
     */
    private int $active;

    /**
     * @ORM\Column(name="item_order", type="integer", nullable=false, options={"default"=0})
     */
    private int $itemOrder;

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

    public function getItemName(): string
    {
        return $this->itemName;
    }

    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
    }

    public function getItemLink(): string
    {
        return $this->itemLink;
    }

    public function setItemLink(string $itemLink): void
    {
        $this->itemLink = $itemLink;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function setActive(int $active): void
    {
        $this->active = $active;
    }

    public function getItemOrder(): int
    {
        return $this->itemOrder;
    }

    public function setItemOrder(int $item_order): void
    {
        $this->itemOrder = $item_order;
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
