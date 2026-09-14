<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_category_id')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->integer('sort')->default(0);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->onDelete('set null');
        });
    }
    public function down() {
        Schema::dropIfExists('faqs');
    }
};
