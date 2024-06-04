<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CurRate;

final readonly class RateDto
{
    public function __construct(
        public string $currencyFrom,
        public string $currencyTo,
        public float $rate,
    ) {
    }
}