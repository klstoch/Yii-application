<?php

declare(strict_types=1);

namespace backend\services\CurrencyPairList;

use backend\vo\Currency;
use backend\vo\CurrencyPair;

final readonly class CurrencyPairCachingDecorator implements CurrencyPairListQueryServiceInterface
{
    private const CACHE_KEY = 'currency_pair_list';

    public function __construct(
        private CurrencyPairListQueryServiceInterface $decorated,
        private \Redis $redis,
        private int $ttl,
    ) {
    }

    public function getPairList(): array
    {
        $serialized = $this->redis->get(self::CACHE_KEY);
        if ($serialized) {
            $currencyPairs = unserialize($serialized, options: ['allowed_classes' => [CurrencyPair::class, Currency::class]]);
        } else {
            $currencyPairs = $this->decorated->getPairList();
            $serialized = serialize($currencyPairs);
            $this->redis->set(self::CACHE_KEY, $serialized, $this->ttl);
        }

        return $currencyPairs;
    }
}