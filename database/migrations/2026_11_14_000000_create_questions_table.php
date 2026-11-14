<?php
// Only needed if the table does not exist yet (yours already does).
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('topic')->nullable();
            $table->text('question');
            $table->json('options');            // ["A text","B text","C text","D text"]
            $table->unsignedTinyInteger('answer'); // 0-based index of the correct option
            $table->text('explanation')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('questions'); }
};
