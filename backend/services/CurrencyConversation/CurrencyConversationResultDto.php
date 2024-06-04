<?php

declare(strict_types=1);

namespace backend\services\CurrencyConversation;

use backend\vo\Money;

final readonly class CurrencyConversationResultDto {
    public function __construct(
        public Money $converted,
        public float $rate,
    ) {
    }
}