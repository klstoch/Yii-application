<?php

declare(strict_types=1);

namespace backend\services\CurrencyPairList;

use backend\vo\CurrencyPair;

interface CurrencyPairListQueryServiceInterface
{
    /**
     * @return array<CurrencyPair>
     */
    public function getPairList(): array;
}