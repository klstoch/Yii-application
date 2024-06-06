<?php

namespace backend\controllers;

use backend\infrastructure\Authentication\HttpBearerAuth;
use backend\services\CurrencyConversation\CurrencyConversationService;
use backend\services\CurrencyPairList\CurrencyListFilter;
use backend\services\CurrencyPairList\CurrencyPairListQueryServiceInterface;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class RatesController extends Controller
{
    /**
     * @return array<string, mixed>
     */
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

    /**
     * @return array<string, mixed>
     */
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

        $currencyFrom = $request->post('currency_from');
        $currencyTo = $request->post('currency_to');
        $value = (float)$request->post('value');
        $result = $currencyConversationService->convert($currencyFrom, $currencyTo, $value);

        return $this->asJson([
            'currency_from' => $currencyFrom,
            'currency_to' => $currencyTo,
            'value' => $value,
            'converted_value' => $result->converted->amount,
            'rate' => $result->rate,
        ]);
    }

    public function actionList(
        CurrencyPairListQueryServiceInterface $currencyPairListQueryService,
        CurrencyListFilter $currencyListFilter,
    ): Response {
        $request = \Yii::$app->request;

        $selectedSecondCurrency = $request->get('selected_second_Currency', []);
        if (!is_array($selectedSecondCurrency)) {
            $selectedSecondCurrency = array_filter(explode(',', $selectedSecondCurrency));
        }

        $pairList = $currencyListFilter->filterBySelectedCurrencies(
            $currencyPairListQueryService->getPairList(),
            $selectedSecondCurrency,
        );

        usort($pairList, function($a, $b) {
            return $a->rate <=> $b->rate;
        });

        $result = [];
        foreach ($pairList as $currencyPair) {
            $result[$currencyPair->secondCurrency->symbol] = $currencyPair->rate;
        }

        return $this->asJson($result);
    }
}
