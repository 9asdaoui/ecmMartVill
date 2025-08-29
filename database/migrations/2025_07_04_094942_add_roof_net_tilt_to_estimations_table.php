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
        Schema::table('estimations', function (Blueprint $table) {
            $table->decimal('roof_net_tilt', 5, 2)->nullable()->after('roof_tilt')->comment('Calculated net tilt considering optimal angle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estimations', function (Blueprint $table) {
            $table->dropColumn('roof_net_tilt');
        });
    }
};
