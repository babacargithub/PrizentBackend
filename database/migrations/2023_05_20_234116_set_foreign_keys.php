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

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        //
        Schema::table("employes",function (Blueprint $table){
            $table->foreignIdFor(Company::class)->nullable(false)->constrained();
        });
       Schema::table('horaires_employes', function (Blueprint $table) {

            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['employe_id', 'jour'], 'Unique_Jour_Employee');

        });
        Schema::table('abonnements', function (Blueprint $table) {

            $table->foreignIdFor(Company::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Formule::class)->nullable(false)->constrained()->restrictOnDelete()->cascadeOnUpdate();

        });
        Schema::table('appareils', function (Blueprint $table) {

            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();

        });
        Schema::table('entrees', function (Blueprint $table) {

            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Journee::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(QrCode::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(["employe_id","journee_id"]);

        });
        Schema::table('sorties', function (Blueprint $table) {

            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Journee::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(QrCode::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(["employe_id","journee_id"]);

        });
        Schema::table('payments', function (Blueprint $table) {

            $table->foreignIdFor(Abonnement::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();


        });
        Schema::table('qr_codes', function (Blueprint $table) {

            $table->foreignIdFor(Company::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(["company_id","nom"]);

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table("employes",function (Blueprint $table){
            $table->dropForeignIdFor(Company::class);

        });
       Schema::table('horaires_employes', function (Blueprint $table) {

            $table->dropForeignIdFor(Employe::class);
        });
        Schema::table('abonnements', function (Blueprint $table) {

            $table->dropForeignIdFor(Company::class);
            $table->dropForeignIdFor(Formule::class);
        });
        Schema::table('appareils', function (Blueprint $table) {

            $table->dropForeignIdFor(Employe::class);
        });
        Schema::table('entrees', function (Blueprint $table) {

            $table->dropForeignIdFor(Employe::class);
            $table->dropForeignIdFor(Journee::class);
            $table->dropForeignIdFor(QrCode::class);
        });
        Schema::table('sorties', function (Blueprint $table) {

            $table->dropForeignIdFor(Employe::class);
            $table->dropForeignIdFor(Journee::class);
            $table->dropForeignIdFor(QrCode::class);
        });
        Schema::table('payments', function (Blueprint $table) {

            $table->dropForeignIdFor(Abonnement::class);
        });
        Schema::table('qr_codes', function (Blueprint $table) {

            $table->dropForeignIdFor(Company::class);
        });

    }
};
