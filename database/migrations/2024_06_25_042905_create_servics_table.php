<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('servics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')->constrained('service_categories')->onDelete('cascade');
            $table->text('title');
            $table->string('photo')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('servics');
    }
};
