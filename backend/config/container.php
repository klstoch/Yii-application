<?php

declare(strict_types=1);

use backend\infrastructure\Provider\CoinCap\CoinCapRatesProviderToCurrencyPairListQueryServiceInterfaceAdapter;
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
    ],
    'singletons' => [
    ],
];