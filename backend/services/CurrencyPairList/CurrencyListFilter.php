<?php

declare(strict_types=1);

namespace backend\services\CurrencyPairList;

final class CurrencyListFilter
{
    public function filterBySelectedCurrencies(array $pairList, array $selectedCurrencies): array
    {
        if (empty($selectedCurrencies)) {
            return $pairList;
        }

        $filteredPairList = [];
        foreach ($pairList as $currencyPair) {
            if (in_array($currencyPair->secondCurrency->symbol, $selectedCurrencies)) {
                $filteredPairList[] = $currencyPair;
            }
        }
        return $filteredPairList;
    }

}