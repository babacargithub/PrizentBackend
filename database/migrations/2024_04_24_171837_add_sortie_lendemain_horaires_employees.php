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
        //
        Schema::table('horaires_employes', function (Blueprint $table) {
            $table->boolean('sortie_lendemain')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('horaires_employes', function (Blueprint $table) {
            $table->dropColumn('sortie_lendemain');
        });
    }
};
