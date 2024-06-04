<?php

declare(strict_types=1);

namespace backend\services\CurrencyPairList;

use backend\vo\CurrencyPair;

final readonly class CurrencyPairPricingDecorator implements CurrencyPairListQueryServiceInterface
{
    public function __construct(
        private CurrencyPairListQueryServiceInterface $decorated,
        private float $percentOfFee,
    ) {
    }

    public function getPairList(): array
    {
        $currencyPairs = $this->decorated->getPairList();

        return array_map(fn (CurrencyPair $pair) => new CurrencyPair(
            $pair->baseCurrencyCode,
            $pair->secondCurrencyCode,
            $pair->rate * ((100 + $this->percentOfFee) / 100),
        ), $currencyPairs);
    }
}