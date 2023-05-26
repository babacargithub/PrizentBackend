<?php

use App\Models\Feature;
use App\Models\Formule;
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
        Schema::create('feature_formule', function (Blueprint $table) {
            $table->id();
            $table->softDeletes();
            $table->foreignIdFor(Formule::class)->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->foreignIdFor(Feature::class)->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->boolean('disabled')->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('feature_formule');
    }
};
