<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('return_code')->nullable();
            $table->string('bank_url')->nullable();
            $table->string('trazability_code')->nullable();
            $table->string('transaction_cycle')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('bank_currency')->nullable();
            $table->string('bank_factor')->nullable();
            $table->string('response_code')->nullable();
            $table->string('response_reason_code')->nullable();
            $table->string('response_reason_text')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
