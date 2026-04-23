<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $defaultCurrency = (string) config('properties.default_currency', 'GHS');

        Schema::table('properties', function (Blueprint $table) use ($defaultCurrency) {
            $table->string('currency', 3)->default($defaultCurrency)->after('price');
        });

        DB::table('properties')
            ->whereNull('currency')
            ->update(['currency' => $defaultCurrency]);
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn('currency');
        });
    }
};
