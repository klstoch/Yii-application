<?php

namespace backend\controllers;

use backend\services\CurrencyConversation\CurrencyConversationService;
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
                    'convert' => ['post'],
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

    public function actionConvert(CurrencyConversationService $currencyConversationService): Response
    {
        $request = \Yii::$app->request;

        $currencyFrom = $request->get('currency_from');
        $currencyTo = $request->get('currency_to');
        $value = (float) $request->get('value');
        $result = $currencyConversationService->convert($currencyFrom, $currencyTo, $value,);

        return $this->asJson([
            'currency_from' => $currencyFrom,
            'currency_to' => $currencyTo,
            'value' => $value,
            'converted_value' => $result->converted->amount,
            'rate' => $result->rate,
        ]);
    }

    public function actionList(CurrencyPairListQueryServiceInterface $currencyPairListQueryService): Response
    {
        $pairList = $currencyPairListQueryService->getPairList();

        $result = [];
        foreach ($pairList as $currencyPair) {
            $result[$currencyPair->secondCurrency->symbol] = $currencyPair->rate;
        }
        ksort($result);

        return $this->asJson($result);
    }
}
