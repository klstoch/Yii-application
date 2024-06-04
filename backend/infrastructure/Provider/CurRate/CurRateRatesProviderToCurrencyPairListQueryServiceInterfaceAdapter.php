<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CurRate;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\vo\Currency;
use backend\vo\CurrencyPair;
use backend\vo\CurrencyTypeEnum;

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
            baseCurrency: new Currency($dto->currencyFrom, CurrencyTypeEnum::FIAT),
            secondCurrency: new Currency($dto->currencyTo, CurrencyTypeEnum::FIAT),
            rate: $dto->rate,
        ), $rates);
    }
}