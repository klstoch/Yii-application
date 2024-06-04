<?php

declare(strict_types=1);

namespace backend\vo;

final readonly class Money
{
    public float $amount;

    public function __construct(
        public Currency $currency,
        float $amount,
    ) {
        if ($amount < 0) {
            throw new \InvalidArgumentException(sprintf('Invalid amount %s', $amount));
        }

        $this->amount = match ($currency->type) {
            CurrencyTypeEnum::CRYPTO => round($amount, 10),
            CurrencyTypeEnum::FIAT => round($amount, 2),
        };
    }
}