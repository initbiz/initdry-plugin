<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Updates;

use Illuminate\Support\Facades\Artisan;
use October\Rain\Database\Updates\Migration;

return new class () extends Migration {
    public function up(): void
    {
        Artisan::call('initdry:cleannotificationrules');
    }

    public function down(): void
    {
    }
};
