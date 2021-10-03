<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id');
            $table->bigInteger('status_id');
            $table->string('comment');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('invoice_shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->string('shipment_id');
            $table->double('total',8,2)->default(0);
            $table->double('shipping_cost',8,2)->default(0);
            $table->double('weight_fees',8,2)->default(0);
            $table->double('service_fees',8,2)->default(0);
            $table->double('due_amount',8,2);
            $table->string('comment');
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
        Schema::dropIfExists('invoice');
        Schema::dropIfExists('invoice_shipments');
    }
}
