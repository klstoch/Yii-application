<?php

declare(strict_types=1);

use backend\infrastructure\Provider\CoinCap\CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter;
use backend\infrastructure\Provider\CurRate\CurRateRatesProvider;
use backend\infrastructure\Provider\CurRate\CurRateRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter;
use backend\services\CurrencyConversation\CurrencyConversationService;
use backend\services\CurrencyPairList\CurrencyListFilter;
use backend\services\CurrencyPairList\CurrencyPairCachingDecorator;
use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\services\CurrencyPairList\CurrencyPairPricingDecorator;
use yii\di\Container;

return [
    'definitions' => [
        \Redis::class => function () {
            $redisConfig = Yii::$app->params['cache']['redis'];

            $redis = new Redis();
            $redis->connect($redisConfig['host'], $redisConfig['port'], $redisConfig['timeout']);

            return $redis;
        },

        CurrencyPairListQueryServiceInterface::class => CurrencyPairCachingDecorator::class,
        CurrencyPairPricingDecorator::class => fn (Container $container) => new CurrencyPairPricingDecorator(
            $container->get(CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter::class),
            Yii::$app->params['percentOfFee'],
        ),
        CurrencyPairCachingDecorator::class => fn (Container $container) => new CurrencyPairCachingDecorator(
            $container->get(CurrencyPairPricingDecorator::class),
            $container->get(Redis::class),
            Yii::$app->params['ratesCachingTtl'],
        ),
        CurrencyConversationService::class => fn (Container $container) => new CurrencyConversationService(
            $container->get(CurrencyPairPricingDecorator::class),
        ),
        CurRateRatesProvider::class => fn (Container $container) => new CurRateRatesProvider(
            Yii::$app->params['providers']['CurRate']['currencyPairCodes'],
            Yii::$app->params['providers']['CurRate']['apiKey'],
        ),
        CurrencyListFilter::class => CurrencyListFilter::class,
    ],
    'singletons' => [
    ],
];