<?php

use App\Models\Company;
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
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->foreignIdFor(Company::class)->nullable(false)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->bigInteger('latitude');
            $table->bigInteger('longitude');
            $table->unique(["company_id","nom"]);
            $table->boolean('disabled')->default(false);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_codes');
    }
};
