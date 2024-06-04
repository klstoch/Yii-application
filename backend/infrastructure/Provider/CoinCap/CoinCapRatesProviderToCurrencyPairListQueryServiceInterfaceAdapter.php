<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CoinCap;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\vo\CurrencyPair;

final class CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter implements CurrencyPairListQueryServiceInterface
{
    public function __construct(
        private readonly CoinCapRatesProvider $coinCapRatesProvider,
    ) {
    }

    public function getPairList(): array
    {
        $rates = $this->coinCapRatesProvider->getRates();

        return array_map(static fn (RateDto $dto) => new CurrencyPair(
            baseCurrencyCode: 'USD',
            secondCurrencyCode: $dto->symbol,
            rate: $dto->rateUsd,
        ), $rates);
    }
}