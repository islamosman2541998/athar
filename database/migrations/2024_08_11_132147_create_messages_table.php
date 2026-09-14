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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // For storing the name, varchar equivalent
            $table->string('email')->nullable(); // For storing the email, varchar equivalent
            $table->string('brand')->nullable(); // For storing the brand, varchar equivalent
            $table->text('message')->nullable(); // For storing the message, text equivalent
            $table->tinyInteger('status')->nullable(); // For storing the status, tiny int equivalent
            $table->text('admin_desc')->nullable(); // For storing admin description, nullable varchar

            $table->unsignedBigInteger('revised_by')->nullable(); // For storing the ID of the user who revised, nullable unsigned big integer

            // Define foreign key constraint
            $table->foreign('revised_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
            ->onUpdate('cascade'); // or 'cascade', 'restrict', 'no action', or 'set null'
// or 'cascade', 'restrict', 'no action', or 'set null'
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
        Schema::dropIfExists('messages');
    }
};
