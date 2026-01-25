<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Models;

use Model;

class FailedJob extends Model
{
    /**
     * @var string table name
     */
    public $table = 'failed_jobs';
}
