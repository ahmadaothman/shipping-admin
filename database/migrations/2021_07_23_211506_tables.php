<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_type', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('name',64);
            $table->bigInteger('range'); //1- super admin,2-company,3-agent,4-global
            $table->string('user_icon', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('user_to_type', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->references('id')->on('users');
            
            $table->string('user_type_id')->references('id')->on('user_type');
        });

        Schema::create('branch', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->unique();
            $table->string('country',4);
            $table->string('city',64);
            $table->string('address')->nullable();
            $table->string('telephone',18);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('agent_group', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('agent', function (Blueprint $table) {
            $table->id();
            $table->string('name',64)->unique();
            $table->string('telephone',64)->unique();
            $table->string('email')->unique();
            $table->string('password',64);
            $table->string('website',64)->nullable();
            $table->string('country',4);
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('status');
            $table->double('special_shiping_cost', 8, 2)->nullable()->default(0);
            $table->double('special_per_weight_fees', 8, 2)->nullable()->default(0);
            $table->double('special_per_volume_cost', 8, 2)->nullable()->default(0);
            $table->bigInteger('sort_order')->nullable()->default(0);
            $table->bigInteger('group_id')->references('id')->on('agent_group')->nullable()->default(0);;
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('payment_method', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->boolean('default');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('currency', function (Blueprint $table) {
            $table->id();
            $table->string('title',64);
            $table->string('code',3);
            $table->string('left_symbole',10);
            $table->string('right_symbole',10);
            $table->float('decimal_number',8);
            $table->boolean('default');
            $table->float('sort_order',8);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('service_type', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->boolean('default');
            $table->bigInteger('sort_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment_status_group', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->bigInteger('sort_order');
            $table->string('color',64);
            $table->string('logo');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment_status', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->bigInteger('shipment_status_group_id')->references('id')->on('shipment_status_group');
            $table->bigInteger('sort_order');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number',64);
            
            $table->string('reference',64);
            $table->bigInteger('agent_id')->references('id')->on('agent');
            $table->bigInteger('status_id')->references('id')->on('shipment_status');
            $table->bigInteger('currency_id')->references('id')->on('currency');
            $table->bigInteger('service_type_id')->references('id')->on('service_type');
            $table->date('preferred_date')->nullable();
            $table->time('preferred_time_from')->nullable();
            $table->time('preferred_time_to')->nullable();

            $table->string('customer_name',64);
            $table->string('customer_email',64)->nullable();
            $table->string('customer_telephone',64);
            $table->string('customer_gender',4)->nullable();
            $table->string('customer_country',64);
            $table->string('customer_state',64)->nullable();
            $table->string('customer_region',64)->nullable();
            $table->string('customer_city',64)->nullable();
            $table->string('customer_building',64)->nullable();
            $table->bigInteger('customer_floor')->nullable();
            $table->string('customer_directions',64);
            $table->string('zip_code',10)->nullable();
            $table->decimal('latitude',10,8)->nullable();
            $table->decimal('longitude',11,8)->nullable();

        
            $table->double('amount',8,2);
            $table->bigInteger('payment_method_id')->references('id')->on('payment_method');
            $table->string('customer_comment')->nullable();
            $table->string('agent_comment')->nullable();

            $table->double('weight',8,2)->nullable()->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment_fees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shipment_id')->references('id')->on('shipment');
            $table->double('amount',8,2);
            $table->string('title',64);
            $table->string('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });


        Schema::create('shipment_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->references('id')->on('users');
            $table->bigInteger('shipment_id')->references('id')->on('shipment');
            $table->bigInteger('status_id')->references('id')->on('shipment_satuts');
            $table->string('comment');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment_feedback', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shipment_id')->references('id')->on('shipment');
            $table->bigInteger('rate');
            $table->string('message');
            $table->boolean('viewed')->nullable()->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('shipment_package', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shipment_id')->references('id')->on('shipment');
            $table->string('reference',64);
            $table->bigInteger('quantity');
            $table->double('weight',8,2)->nullable();
            $table->double('volume',8,2)->nullable();
            $table->string('unit',64)->nullable()->default('piece');
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('package_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('package_id')->references('id')->on('shipment_packages');
            $table->string('link');
            $table->string('comment')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('setting', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->default(0);
            $table->string('setting', 100);
            $table->string('value');
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
        Schema::dropIfExists('user_type');
        Schema::dropIfExists('user_to_type');
        Schema::dropIfExists('branch');
        Schema::dropIfExists('agent_group');
        Schema::dropIfExists('agent');
        Schema::dropIfExists('payment_method');
        Schema::dropIfExists('currency');
        Schema::dropIfExists('service_type');
        Schema::dropIfExists('shipment_status_group');
        Schema::dropIfExists('shipment_status');
        Schema::dropIfExists('shipment');
        Schema::dropIfExists('shipment_fees');
        Schema::dropIfExists('shipment_history');
        Schema::dropIfExists('shipment_feedback');
        Schema::dropIfExists('shipment_package');
        Schema::dropIfExists('package_attachments');
        Schema::dropIfExists('setting');
    }
}
