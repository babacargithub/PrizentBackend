<?php


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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('maximum_distance');
            $table->integer('number')->nullable();
            $table->tinyInteger("type")->unsigned()->nullable(false);
            $table->boolean('disabled')->default(false);
            $table->timestamps();
            $table->softDeletes();

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
