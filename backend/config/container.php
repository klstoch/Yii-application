<?php

declare(strict_types=1);

use backend\infrastructure\Provider\CoinCap\CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter;
use backend\infrastructure\Provider\CurRate\CurRateRatesProvider;
use backend\infrastructure\Provider\CurRate\CurRateRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter;
use backend\services\CurrencyConversation\CurrencyConversationService;
use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use backend\services\CurrencyPairList\CurrencyPairPricingDecorator;
use yii\di\Container;

return [
    'definitions' => [
        CurrencyPairListQueryServiceInterface::class => CurrencyPairPricingDecorator::class,
        CurrencyPairPricingDecorator::class => fn (Container $container) => new CurrencyPairPricingDecorator(
            $container->get(CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter::class),
            Yii::$app->params['percentOfFee'],
        ),
        CurrencyConversationService::class => fn (Container $container) => new CurrencyConversationService(
            $container->get(CurrencyPairPricingDecorator::class),
        ),
        CurRateRatesProvider::class => fn (Container $container) => new CurRateRatesProvider(
            Yii::$app->params['providers']['CurRate']['currencyPairCodes'],
            Yii::$app->params['providers']['CurRate']['apiKey'],
        ),
    ],
    'singletons' => [
    ],
];