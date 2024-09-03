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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_category_id')->nullable()->constrained('portfolio_categories')->onDelete('cascade');
            $table->text('title');
            $table->string('photo')->nullable();
            $table->string('status');
            $table->string('url')->nullable();
            $table->integer('view')->default(0);
            $table->text('descriptions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
