<?php

declare(strict_types=1);

namespace Initbiz\InitDry\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFailedJobsTable Migration
 *
 * @link https://docs.octobercms.com/3.x/extend/database/structure.html
 */
return new class () extends Migration {
    /**
     * up builds the migration
     */
    public function up()
    {
        Schema::create('initbiz_initdry_failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * down reverses the migration
     */
    public function down()
    {
        Schema::dropIfExists('initbiz_initdry_failed_jobs');
    }
};
