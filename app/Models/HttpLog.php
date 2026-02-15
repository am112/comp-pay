<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HttpLog extends Model
{
    protected $table = 'http_logs';

    public function archive()
    {
        /** convert data to excel and store to storage/s3 */
    }
}
