<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CoinCap;

final readonly class RateDto
{
    public function __construct(
        public string $id,
        public string $symbol,
        public ?string $currencySymbol,
        public string $type,
        public float $rateUsd,
    ) {
    }
}