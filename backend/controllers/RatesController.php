<?php

namespace backend\controllers;

use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class RatesController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => HttpBearerAuth::class,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['get'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionList(CurrencyPairListQueryServiceInterface $currencyPairListQueryService): Response
    {
        $pairList = $currencyPairListQueryService->getPairList();

        $result = [];
        foreach ($pairList as $currencyPair) {
            $result[$currencyPair->secondCurrencyCode] = $currencyPair->rate;
        }
        ksort($result);

        return $this->asJson($result);
    }
}
