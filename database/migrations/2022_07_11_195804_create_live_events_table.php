<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('event_type')->default('live');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->text('embed')->nullable();
            $table->boolean('has_live_offer')->default(false);
            $table->string('name_offer')->nullable();
            $table->text('description_offer')->nullable();
            $table->string('embed_offer')->nullable();
            $table->boolean('offer_available')->default(false);
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->boolean('has_link_with_content')->default(false)->nullable();
            $table->foreignId('content_id')->nullable()->constrained();
            $table->nullableMorphs('linkable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('live_events');
    }
}
