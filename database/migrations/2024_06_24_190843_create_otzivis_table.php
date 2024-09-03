<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('otzivis', function (Blueprint $table) {
            $table->id();
            $table->string('FIO');
            $table->string('job_title');
            $table->string('photo')->nullable();
            $table->text('descriptions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otzivis');
    }
};
