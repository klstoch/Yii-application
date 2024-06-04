<?php

declare(strict_types=1);

namespace backend\services\CurrencyConversation;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;

final readonly class CurrencyConversationService
{
    public function __construct(
        private CurrencyPairListQueryServiceInterface $currencyPairsQueryService,
    ) {
    }

    public function convert(string $currencyFrom, string $currencyTo, float $amount): CurrencyConversationResultDto
    {
        $currencyPairs = $this->currencyPairsQueryService->getPairList();
        foreach ($currencyPairs as $currencyPair) {
            if ($currencyPair->baseCurrency->symbol === $currencyFrom && $currencyPair->secondCurrency->symbol === $currencyTo) {
                $rate = $currencyPair->rate;
                $secondCurrency = $currencyPair->secondCurrency;
            } elseif ($currencyPair->baseCurrency->symbol === $currencyTo && $currencyPair->secondCurrency->symbol === $currencyFrom) {
                $rate = 1 / $currencyPair->rate;
                $secondCurrency = $currencyPair->baseCurrency;
            } else {
                continue;
            }
            $convertedAmount = $amount * $rate;
            return new CurrencyConversationResultDto($convertedAmount, $rate);
        }
        throw new \RuntimeException();
    }
}