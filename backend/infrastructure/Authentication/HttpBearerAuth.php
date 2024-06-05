<?php

declare(strict_types=1);

namespace backend\infrastructure\Authentication;

final class HttpBearerAuth extends \yii\filters\auth\HttpBearerAuth
{
    public $pattern = '/^[a-zA-Z0-9-_]{64}$/';
}