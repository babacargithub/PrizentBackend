<?php

use App\Models\Abonnement;
use App\Models\Company;
use App\Models\Employe;
use App\Models\Formule;
use App\Models\Journee;
use App\Models\QrCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {

        Schema::table('pointages', function (Blueprint $table) {

            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Journee::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(QrCode::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(["employe_id", "journee_id"]);

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {

        Schema::table('pointages', function (Blueprint $table) {

            $table->dropForeignIdFor(Employe::class);
            $table->dropForeignIdFor(Journee::class);
            $table->dropForeignIdFor(QrCode::class);
        });

    }
};
