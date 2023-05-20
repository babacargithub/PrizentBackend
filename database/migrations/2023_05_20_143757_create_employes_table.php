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
        Schema::create('employes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->string('prenom', 256);
            $table->string('nom', 256);
            $table->char('sexe',1);
            $table->boolean('disabled')->default(false);
            $table->string('email', 256)->unique()->nullable();
            $table->integer('telephone')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
};
