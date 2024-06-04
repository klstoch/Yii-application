<?php

declare(strict_types=1);

namespace backend\services\CurrencyConversation;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\vo\Money;

final readonly class CurrencyConversationService
{
    public function __construct(
        private CurrencyPairListQueryServiceInterface $currencyPairsQueryService,
    ) {
    }

    public function convert(string $currencyFrom, string $currencyTo, float $amount): CurrencyConversationResultDto
    {
        if ($amount < 0.01) {
            throw new \InvalidArgumentException('From value must be greater or equals to 0.01');
        }

        $currencyPairs = $this->currencyPairsQueryService->getPairList();
        foreach ($currencyPairs as $currencyPair) {
            if ($currencyPair->baseCurrency->symbol === $currencyFrom && $currencyPair->secondCurrency->symbol === $currencyTo) {
                $rate = $currencyPair->rate;
                $currency = $currencyPair->secondCurrency;
            } elseif ($currencyPair->baseCurrency->symbol === $currencyTo && $currencyPair->secondCurrency->symbol === $currencyFrom) {
                $rate = 1 / $currencyPair->rate;
                $currency = $currencyPair->baseCurrency;
            } else {
                continue;
            }

            $converted = new Money($currency, $amount * $rate);
            return new CurrencyConversationResultDto($converted, $rate);
        }
        throw new \RuntimeException();
    }
}