<?php

use App\Models\Company;
use App\Models\Params;
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
        Schema::create('company_params', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable("false")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Params::class)->nullable("false")->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean("enabled")->default(false);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('company_params');
    }
};
