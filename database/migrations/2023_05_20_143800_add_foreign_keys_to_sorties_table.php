<?php

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
        Schema::table('sorties', function (Blueprint $table) {
            $table->foreign(['id'], 'sorties_ibfk_1')->references(['id'])->on('employes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['id'], 'sorties_ibfk_2')->references(['id'])->on('qr_codes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sorties', function (Blueprint $table) {
            $table->dropForeign('sorties_ibfk_1');
            $table->dropForeign('sorties_ibfk_2');
        });
    }
};
