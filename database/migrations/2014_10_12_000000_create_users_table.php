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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();

            $table->string('prefix')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();

            $table->string('job_title')->nullable();
            $table->string('role')->nullable();

            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();

            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();

            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_sector')->nullable();
            $table->string('company_website')->nullable();

            $table->string('image_url')->nullable();

            $table->tinyInteger('deprecated')->default(0);

            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
