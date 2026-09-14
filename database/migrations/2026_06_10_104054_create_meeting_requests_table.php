<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('company')->nullable();
            $table->string('job_title')->nullable();

            $table->string('meeting_type')->nullable(); 

            $table->date('preferred_date')->nullable();
            $table->time('preferred_time')->nullable();

            $table->text('message')->nullable();

            $table->string('status')->default('new');
            // new / contacted / scheduled / cancelled / done

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};