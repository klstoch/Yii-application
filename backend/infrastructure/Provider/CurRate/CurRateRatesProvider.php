<?php

declare(strict_types=1);

namespace backend\infrastructure\Provider\CurRate;

use backend\infrastructure\Provider\ProviderException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

final readonly class CurRateRatesProvider
{

    private const API_URL_TEMPLATE = 'https://currate.ru/api/?get=rates&pairs=%s&key=%s';

    private string $apiUrl;

    public function __construct(array $currencyPairCodes, string $apiKey)
    {
        $this->apiUrl = sprintf(
            self::API_URL_TEMPLATE,
            implode(',', $currencyPairCodes),
            $apiKey,
        );
    }

    /**
     * @return array<RateDto>
     */
    public function getRates(): array
    {
        $httpClient = new Client();

        try {
            $response = $httpClient->get($this->apiUrl)->send();
        } catch (Exception $e) {
            throw new ProviderException('An error occurred when http request send to provider CurRate', previous: $e);
        }

        if (!$response->isOk) {
            throw new ProviderException('Request to provider CurRate failed');
        }

        $content = $response->getContent();
        if (empty($content)) {
            return [];
        }

        try {
            $responseAsArray = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new ProviderException('Cant decode json from provider CurRate');
        }

        $result = [];
        foreach ($responseAsArray['data'] as $currencyPairCode => $rate) {
            $currencyFrom = substr($currencyPairCode, 0, 3);
            $currencyTo = substr($currencyPairCode, 3, 3);
            $result[] = new RateDto($currencyFrom, $currencyTo, (float) $rate);
        }

        return $result;
    }
}