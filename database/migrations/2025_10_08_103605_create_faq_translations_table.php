<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('faq_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faq_id')->index();
            $table->string('locale')->index();
            $table->string('question')->nullable();
            $table->longText('answer')->nullable();
            $table->unique(['faq_id','locale']);
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
        });
    }
    public function down() {
        Schema::dropIfExists('faq_translations');
    }
};
