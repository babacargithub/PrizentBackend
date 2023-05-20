<?php

use App\Models\Employe;
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
        Schema::create('entrees', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Journee::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->time('scanned_at' );
            $table->integer('ponctualite');
            $table->unique(["employe_id","journee_id"]);
            $table->foreignIdFor(QrCode::class)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('entrees');
    }
};
