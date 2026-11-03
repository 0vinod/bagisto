<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    
        Schema::create('tet_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Profiles (Linked to tet_users)
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId('id')->primary()->constrained('tet_users')->onDelete('cascade');
            $table->text('full_name')->nullable();
            $table->text('role')->default('student'); // 'admin' or 'student'
            $table->timestamp('created_at')->useCurrent();
        });

        // 3. Levels
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });

        // 4. Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('emoji')->nullable();
            $table->text('color')->nullable();
            $table->text('short_note')->nullable();
            $table->integer('sort_order')->default(0);
        });

        // 5. Notes
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->text('title');
            $table->text('image_url')->nullable();
            $table->integer('sort_order')->default(0);
        });

        // 6. Note Points
        Schema::create('note_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->nullable()->constrained('notes')->onDelete('cascade');
            $table->text('heading');
            $table->json('points'); // MySQL JSON
            $table->integer('sort_order')->default(0);
        });

        // 7. Questions
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->text('question');
            $table->json('options');
            $table->integer('answer');
            $table->text('explanation')->nullable();
        });

        // 8. Options
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
        });

        // 9. Syllabus Topics
        Schema::create('syllabus_topics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->text('name');
            $table->text('detail')->nullable();
            $table->integer('sort_order')->default(0);
        });

        // 10. Syllabus Items
        Schema::create('syllabus_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->nullable()->constrained('syllabus_topics')->onDelete('cascade');
            $table->text('heading');
            $table->integer('sort_order')->default(0);
        });

        // 11. Syllabus Progress (Linked to tet_users)
        Schema::create('syllabus_progress', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('tet_users')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('syllabus_items')->onDelete('cascade');
            $table->timestamp('created_at')->nullable()->useCurrent();
            
            // Composite Primary Key
            $table->primary(['user_id', 'item_id']);
        });

        // 12. Attempts (Linked to tet_users)
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('tet_users')->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('cascade');
            $table->foreignId('question_id')->nullable()->constrained('questions')->onDelete('cascade');
            $table->integer('selected')->nullable();
            $table->boolean('is_correct');
            $table->timestamp('created_at')->nullable()->useCurrent();
        });

        // 13. Attempt Answers
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
        // Drop in reverse order to avoid foreign key constraint errors
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
        Schema::dropIfExists('levels');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('tet_users');
    }
};