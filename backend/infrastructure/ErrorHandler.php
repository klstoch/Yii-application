<?php

declare(strict_types=1);

namespace backend\infrastructure;

use yii\web\HttpException;

final class ErrorHandler extends \yii\web\ErrorHandler
{
    public function renderException($exception): void
    {
        $response = \Yii::$app->response;
        if ($exception instanceof HttpException) {
            $statusCode = $exception->statusCode;
            $errorMessage = $exception->getMessage();
        } elseif ($exception instanceof \InvalidArgumentException) {
            $statusCode = 400;
            $errorMessage = $exception->getMessage();
        } else {
            $statusCode = 500;
            $errorMessage = 'Internal server error';
        }

        $response->statusCode = $statusCode;
        $response->content = json_encode([
            'status' => 'error',
            'code' => $statusCode,
            'message' => $errorMessage,
        ]);

        $response->send();
    }
}