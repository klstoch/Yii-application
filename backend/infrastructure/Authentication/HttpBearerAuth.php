<?php

declare(strict_types=1);

namespace backend\infrastructure\Authentication;

use yii\web\UnauthorizedHttpException;

final class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    public $pattern = '/^Bearer\s+([a-zA-Z0-9-_]{64})$/';

    public function handleFailure($response)
    {
        throw new UnauthorizedHttpException('Invalid token');
    }
}