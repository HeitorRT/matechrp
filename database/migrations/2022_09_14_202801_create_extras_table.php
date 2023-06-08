<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extras', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['arquivo', 'bastidor', 'debate', 'trailer'])->nullable();
            $table->string('name')->nullable();
            $table->enum('player', ['vimeo', 'sambatech'])->nullable();
            $table->text('embed')->nullable();
            $table->foreignId('content_id')->constrained();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('extras');
    }
}
