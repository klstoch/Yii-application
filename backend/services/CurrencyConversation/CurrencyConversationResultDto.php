<?php

declare(strict_types=1);

namespace backend\services\CurrencyConversation;

final readonly class CurrencyConversationResultDto {
    public function __construct(
        public float $convertedAmount,
        public float $rate,
    ) {
    }
}