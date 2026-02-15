<?php

namespace App\Enums;

enum InvoiceStatusEnum: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case PROCESSING = 'processing';

}
