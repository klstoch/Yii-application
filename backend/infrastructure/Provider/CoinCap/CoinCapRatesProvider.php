<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CoinCap;

use backend\infrastructure\Provider\ProviderException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

final class CoinCapRatesProvider
{
    private const API_URL = 'https://api.coincap.io/v2/rates';

    /**
     * @return array<RateDto>
     */
    public function getRates(): array
    {
        $httpClient = new Client();

        try {
            $response = $httpClient->get(self::API_URL)->send();
        } catch (Exception $e) {
            throw new ProviderException('An error occurred when http request send', previous: $e);
        }

        if (!$response->isOk) {
            throw new ProviderException('Request failed');
        }

        $content = $response->getContent();
        if (empty($content)) {
            return [];
        }

        try {
            $responseObject = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ProviderException('Cant decode json');
        }

        return array_map(fn (\stdClass $rateData) => new RateDto(
            id: $rateData->id,
            symbol: $rateData->symbol,
            currencySymbol: $rateData->currencySymbol,
            type: $rateData->type,
            rateUsd: (float) $rateData->rateUsd,
        ), $responseObject->data);
    }
}