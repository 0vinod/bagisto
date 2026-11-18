<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     
    private function ts(Blueprint $table, bool $createdNullable = false): void
    {
        $c = $table->timestamp('created_at');
        $createdNullable ? $c->nullable()->useCurrent() : $c->useCurrent();
        $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
    }

    public function up(): void
    {
        // 1. Users
        Schema::create('tet_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('email', 191)->unique('tet_users_email_unique');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->string('remember_token', 100)->nullable();
            $table->string('status', 10)->default('1');
            $table->timestamps();  
        });

        // 2. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('emoji', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->text('short_note')->nullable();
            $table->string('weightage', 50)->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $this->ts($table);
            $table->string('image_url', 150)->nullable();
        });

        // 3. Notes
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->text('title');
            $table->text('image_url')->nullable();
            $table->string('icon_url', 100)->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('Short_notes', 250)->nullable();
            $table->string('weightage', 50)->nullable();
            $this->ts($table);
        });

        // 4. Note Points
        Schema::create('note_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->nullable()->constrained('notes')->onDelete('cascade');
            $table->text('heading');
            $table->string('sub_headings', 150)->nullable();
            $table->json('points');
            $table->integer('sort_order')->default(0);
            $table->string('image_url', 150)->nullable();
            $this->ts($table);
        });

        // 5. Questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->string('topic', 100)->nullable();
            $table->text('question');
            $table->json('options')->nullable();
            $table->string('answer', 256);          // was unsignedTinyInteger
            $table->text('explanation')->nullable();
            $this->ts($table);
        });

        // 6. Options
        // NOTE: this table is NOT in your SQL dump, but attempt_answers.option_id
        // has a foreign key to it, so it must exist.
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->text('option_text');
            $table->text('option_image_path')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->integer('sort_order')->default(0);
            $table->text('option_text_hi')->nullable();
            $table->text('description_hi')->nullable();
            $table->timestamps();
        });

        // 7. Syllabus Topics
        Schema::create('syllabus_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name', 255);
            $table->text('detail')->nullable();
            $table->string('weightage', 50)->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $this->ts($table);
        });

        // 8. Syllabus Items
        Schema::create('syllabus_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained('syllabus_topics')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('heading', 255);
            $table->integer('sort_order')->nullable()->default(0);
            $this->ts($table);
        });

        // 9. Syllabus Progress (has its own id + unique pair, not a composite PK)
        Schema::create('syllabus_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tet_users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('syllabus_items')->cascadeOnDelete()->cascadeOnUpdate();
            $this->ts($table, true);

            $table->unique(['user_id', 'item_id'], 'unique_user_item');
        });

        // 10. Attempts
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tet_users')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade');
            $table->integer('selected')->nullable();
            $table->boolean('is_correct');
            $this->ts($table, true);
        });

        // 11. Attempt Answers (no timestamps in dump)
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('attempts')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('option_id')->nullable()->constrained('options')->onDelete('set null');
            $table->boolean('is_correct');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
        Schema::dropIfExists('attempts');
        Schema::dropIfExists('syllabus_progress');
        Schema::dropIfExists('syllabus_items');
        Schema::dropIfExists('syllabus_topics');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('note_points');
        Schema::dropIfExists('notes');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('tet_users');
    }
};