<?php

namespace App\Entity;

use App\Repository\NumberStoreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NumberStoreRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class NumberStore
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private int $number;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $updatedAt;

    public function __construct(int $number)
    {
        $this->number = $number;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
