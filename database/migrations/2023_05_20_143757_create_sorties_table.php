<?php

use App\Models\Employe;
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
    public function up()
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignIdFor(Employe::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->time('scanned_at', );
            $table->integer('ponctualite');
            $table->foreignIdFor(QrCode::class)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sorties');
    }
};
