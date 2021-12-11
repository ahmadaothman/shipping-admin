<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100);
            $table->text('description');
            $table->string('reference', 100)->nullable()->default('0');
            $table->float('amount');
            $table->string('currency', 10);
            $table->float('currency_rate')->nullable()->default(1);
            $table->float('vat');
            $table->text('note');
            $table->date('expense_date');
            $table->bigInteger('user_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
