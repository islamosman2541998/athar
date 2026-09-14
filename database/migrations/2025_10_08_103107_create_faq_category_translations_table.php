<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('faq_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_category_id')->index();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->unique(['faq_category_id','locale']);
            $table->foreign('faq_category_id')->references('id')->on('faq_categories')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('faq_category_translations');
    }
};
