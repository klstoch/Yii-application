<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CurRate;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\vo\CurrencyPair;

final class CurRateRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter implements CurrencyPairListQueryServiceInterface
{
    public function __construct(
        private readonly CurRateRatesProvider $curRateRatesProvider,
    ) {
    }

    public function getPairList(): array
    {
        $rates = $this->curRateRatesProvider->getRates();

        return array_map(static fn (RateDto $dto) => new CurrencyPair(
            baseCurrencyCode: $dto->currencyFrom,
            secondCurrencyCode: $dto->currencyTo,
            rate: $dto->rate,
        ), $rates);
    }
}