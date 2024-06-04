<?php

declare(strict_types=1);

namespace backend\vo;

final readonly class CurrencyPair
{
    public function __construct(
        public string $baseCurrencyCode,
        public string $secondCurrencyCode,
        public float $rate,
    ) {
    }
}