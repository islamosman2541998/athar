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
        if (Schema::hasTable('order_extra_details')) {
            return;
        }

        Schema::create('order_extra_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null'); // Foreign key to users table
            $table->boolean('ship_to_me')->nullable()->default(0)->comment(' 1 = yes   ,  0 = no  ');
            $table->text('greeting_card')->nullable();
            $table->text('extra_instructions')->nullable();

            $table->boolean('know_receipent_address')->nullable()->default(1)->comment(' [1 = yes   ,  0 = no]   it is shown only when the ship to me column is zero ');
            $table->boolean('same_day')->nullable()->default(1)->comment(' [1 = yes   ,  0 = no]   ');
            $table->timestamp('delivery_date')->nullable();
            $table->boolean('specific_time_slot_status')->nullable()->default(0)->comment(' [1 = yes   ,  0 = no]   ');
            $table->time('specific_time')->nullable()->comment('  it is set only when specific_time_slot_status is set to 1  ');

            $table->boolean('delivery_place')->nullable()->default(1)->comment(' [1 = home   ,  0 = office]   ');
            $table->boolean('hide_my_name_status')->nullable()->default(0)->comment(' [1 = yes hide it  ,  0 = no show it]   ');



            $table->string('st_name', 100)->nullable();
            $table->float('shipping_cost', 14, 2)->nullable();


            $table->tinyInteger('status')->default(0)->nullable();

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
        Schema::dropIfExists('order_extra_details');
    }
};
