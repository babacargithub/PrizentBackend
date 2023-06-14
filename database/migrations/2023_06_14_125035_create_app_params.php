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
        Schema::create('app_params', function (Blueprint $table) {
            $table->id();
            $table->integer("maximum_distance")->default(3000);
            $table->integer("trial_period_days")->default(2);
            $table->integer("mobile_build_number")->default(1);
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
        Schema::dropIfExists('app_params');
    }
};
