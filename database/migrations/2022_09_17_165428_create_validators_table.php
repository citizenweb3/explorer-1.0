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
        Schema::create('validators', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rank');
            $table->string('account_address')->unique();
            $table->string('operator_address');
            $table->string('consensus_pubkey');
            $table->boolean('jailed');
            $table->tinyInteger('status');
            $table->string('tokens');
            $table->string('delegator_shares');
            $table->string('moniker');
            $table->string('identity');
            $table->string('website');
            $table->text('details');
            $table->string('unbonding_height');
            $table->string('unbonding_time');
            $table->string('rate');
            $table->string('max_rate');
            $table->string('max_change_rate');
            $table->timestampTz('update_time');
            $table->json('uptime');
            $table->string('min_self_delegation');
            $table->string('keybase_url');
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
        Schema::dropIfExists('validators');
    }
};
