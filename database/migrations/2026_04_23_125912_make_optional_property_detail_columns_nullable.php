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
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedTinyInteger('bedrooms')->nullable()->default(null)->change();
            $table->unsignedTinyInteger('bathrooms')->nullable()->default(null)->change();
            $table->unsignedTinyInteger('garage_spaces')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->unsignedTinyInteger('bedrooms')->default(0)->nullable(false)->change();
            $table->unsignedTinyInteger('bathrooms')->default(0)->nullable(false)->change();
            $table->unsignedTinyInteger('garage_spaces')->default(0)->nullable(false)->change();
        });
    }
};
