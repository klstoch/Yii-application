<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CoinCap;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\vo\Currency;
use backend\vo\CurrencyPair;
use backend\vo\CurrencyTypeEnum;

final class CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter implements CurrencyPairListQueryServiceInterface
{
    public function __construct(
        private readonly CoinCapRatesProvider $coinCapRatesProvider,
    ) {
    }

    public function getPairList(): array
    {
        $rates = $this->coinCapRatesProvider->getRates();

        $result = [];
        foreach ($rates as $rate) {
            try {
                $currencyType = $this->translateCurrencyType($rate->type);
            } catch (\InvalidArgumentException) {
                continue;
            }

            $result[] = new CurrencyPair(
                baseCurrency: new Currency('USD', CurrencyTypeEnum::FIAT),
                secondCurrency: new Currency($rate->symbol, $currencyType),
                rate: 1 / $rate->rateUsd,
            );
        }

        return $result;
    }

    private function translateCurrencyType(string $type): CurrencyTypeEnum
    {
        if ($type === 'fiat') {
            return CurrencyTypeEnum::FIAT;
        }

        if ($type === 'crypto') {
            return CurrencyTypeEnum::CRYPTO;
        }

        throw new \InvalidArgumentException(sprintf('Currency type %s not supported', $type));
    }
}