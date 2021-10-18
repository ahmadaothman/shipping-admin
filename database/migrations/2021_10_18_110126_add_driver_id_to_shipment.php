<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDriverIdToShipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipment', function (Blueprint $table) {
            
            $table->integer('driver_id',false)->nullable()->default(0)->after('agent_comment');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipment', function (Blueprint $table) {
            $table->dropColumn('driver_id');
        });
    }
}
