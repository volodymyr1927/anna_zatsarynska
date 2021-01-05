<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", unique=true, nullable=false, options={"unsigned"=true})
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=false, length=255)
     */
    private $image;

    /**
     * @var int
     * @ORM\Column(name="name_crc32", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $nameCrc32;

    /**
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"=true})
     */
    private $active;

    /**
     * @ORM\Column(name="width", type="string", length=25, nullable=false, columnDefinition="ENUM('50','100')")
     */
    private $width = '50';

    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt;


    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getNameCrc32(): int
    {
        return $this->nameCrc32;
    }

    /**
     * @param int $nameCrc32
     */
    public function setNameCrc32(int $nameCrc32): void
    {
        $this->nameCrc32 = $nameCrc32;
    }

    /**
     * @return boolean
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }


}
