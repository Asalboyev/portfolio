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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories')->onDelete('cascade');
            $table->text('title');
            $table->text('standard_key')->nullable();
            $table->text('optional_key')->nullable() ;
            $table->text('photo')->nullable();
            $table->string('price');
            $table->string('status');
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('products');
    }
};
