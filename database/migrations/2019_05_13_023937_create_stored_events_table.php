<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateStoredEventsTable
 */
final class CreateStoredEventsTable extends Migration
{
    public function up()
    {
        Schema::create('stored_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aggregate_uuid')->nullable();
            $table->bigInteger('version');
            $table->string('event_class');
            $table->json('event_properties');
            $table->json('meta_data');
            $table->timestamp('created_at');

            $table->index('event_class');
            $table->index('aggregate_uuid');
            $table->unique(['aggregate_uuid', 'version']);
        });
    }
}
