<?php

declare(strict_types=1);

namespace backend\vo;

final readonly class CurrencyPair
{
    public function __construct(
        public Currency $baseCurrency,
        public Currency $secondCurrency,
        public float $rate,
    ) {
    }
}