<?php

namespace App\Enums;

enum InvoiceTypeEnum: string
{
    case CONSENT = 'consent';
    case COLLECTION = 'collection';
    case INSTANT = 'instant';

}
