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
        Schema::create('horaires_employes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jour');
            $table->time('entree');
            $table->time('sortie');
            $table->integer('employe_id');
            $table->unique(['employe_id', 'jour'], 'Unique_Jour_Employee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horaires_employes');
    }
};
