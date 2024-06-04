<?php

declare(strict_types=1);

namespace backend\vo;

enum CurrencyTypeEnum : string
{
   case FIAT = 'fiat';
   case CRYPTO = 'crypto';
}
