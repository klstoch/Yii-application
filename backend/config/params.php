<?php
return [
    'cache' => [
        'redis' => [
            'host' => 'redis',
            'port' => 6379,
            'timeout' => 0,
        ],
    ],

    'adminEmail' => 'admin@example.com',
    'percentOfFee' => 2,

    'providers' => [
        'CurRate' => [
            'apiKey' => 'df11acebc31b3ba6f08f900ae69b9dce',
            'currencyPairCodes' => [
                'USDAED',
                'USDAMD',
                'USDAUD',
                'USDBGN',
                'USDBYN',
                'USDCAD',
                'USDGBP',
                'USDILS',
                'USDJPY',
                'USDKGS',
                'USDKZT',
                'USDMYR',
                'USDRUB',
                'USDTHB',
                'USDUAH',
                'USDVND',
            ],
        ],
    ],
];
