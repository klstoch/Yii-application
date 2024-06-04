<?php

declare(strict_types=1);

namespace backend\vo;

final readonly class Currency
{
    public string $symbol;

    public function __construct(
        string $symbol,
        public CurrencyTypeEnum $type,
    ) {
        if (!preg_match('/^\w{3,5}$/', $symbol)) {
            throw new \InvalidArgumentException(sprintf('Invalid currency symbol %s', $symbol));
        }
        $this->symbol = strtoupper($symbol);
    }
}