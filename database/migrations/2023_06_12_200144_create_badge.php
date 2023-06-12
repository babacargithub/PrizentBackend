<?php

use App\Models\Employe;
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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->integer("number")->unique()->nullable(false);
            $table->dateTime("last_used_at")->nullable();
            $table->boolean("disabled")->default(false)->nullable(false);
            $table->integer("belongs_to_batch")->nullable(false);
            $table->foreignIdFor(Employe::class)->nullable()->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('badges');
    }
};
