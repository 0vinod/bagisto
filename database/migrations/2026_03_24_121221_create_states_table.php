<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('country_name', 191)->nullable();
            $table->string('state_name', 191);
            $table->integer('status',10)->default(1);
            $table->bigInteger('country_id')->default(1);
            $table->timestamps();
        });

        schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('state_name', 191);
            $table->string('city_name', 191);
            $table->bigInteger('state_id');
            $table->integer('status',10)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
