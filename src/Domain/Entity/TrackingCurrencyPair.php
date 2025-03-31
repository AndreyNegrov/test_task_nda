<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Index(name: 'isTracked_index', columns: ['is_tracked'])]
class TrackingCurrencyPair
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 3)]
    private string $baseCurrency;

    #[ORM\Column(length: 3)]
    private string $targetCurrency;

    #[ORM\Column(type: Types::STRING, nullable: true)]
    private ?string $error;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isTracked;

    public function __construct(
        string $baseCurrency,
        string $targetCurrency,
        bool $isTracked,
        ?string $error = null
    ) {
        $this->baseCurrency = $baseCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->isTracked = $isTracked;
        $this->error = $error;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }

    public function isTracked(): bool
    {
        return $this->isTracked;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): void
    {
        $this->error = $error;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->setUpdatedAt(new DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
