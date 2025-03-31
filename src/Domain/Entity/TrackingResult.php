<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity()]
#[ORM\Index(name: 'create_at_index', columns: ['tracking_currency_pair_id', 'created_at'])]
class TrackingResult
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TrackingCurrencyPair::class)]
    #[ORM\JoinColumn(referencedColumnName: 'id')]
    private TrackingCurrencyPair $trackingCurrencyPair;

    #[ORM\Column(type: Types::FLOAT)]
    private float $rate;

    public function __construct(
        TrackingCurrencyPair $trackingCurrencyPair,
        float $rate,
    ) {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        $this->trackingCurrencyPair = $trackingCurrencyPair;
        $this->rate = $rate;
    }

    #[ORM\PreUpdate()]
    public function setUpdatedAtValue(): void
    {
        $this->setUpdatedAt(new DateTime());
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getTrackingCurrencyPair(): TrackingCurrencyPair
    {
        return $this->trackingCurrencyPair;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
