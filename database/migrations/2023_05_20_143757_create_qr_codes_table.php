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
    public function up(): void
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->bigInteger('latitude');
            $table->bigInteger('longitude');
            $table->boolean('disabled')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_codes');
    }
};
