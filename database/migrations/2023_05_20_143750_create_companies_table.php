<?php

use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 256)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('adresse')->nullable();
            $table->string('logo')->nullable();
            $table->string('region')->nullable();
            $table->foreignIdFor(User::class)
                ->unique()
                ->nullable(false)
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->bigInteger('telephone')->unique();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
