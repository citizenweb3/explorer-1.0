<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validator_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validator_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('height');
            $table->string('msg_type');
            $table->decimal('voting_power', 16, 6);
            $table->decimal('new_voting_power', 16, 6);
            $table->string('tx_hash');
            $table->timestampTz('timestamp');
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
        Schema::dropIfExists('validator_events');
    }
};
