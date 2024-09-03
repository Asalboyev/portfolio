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
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->string('telegram');
            $table->string('instagram');
            $table->integer('project_completed')->nullable();
            $table->integer('client_satisfied')->nullable();
            $table->integer('design_project')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedln')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
        DB::table('information')->insert([
            'phone' => '979040706',
            'telegram' => 'https://t.me/akhror.asalbayev',
            'instagram' => 'https://t.me/akhror.asalbayev',
            'youtube' => 'https://t.me/akhror.asalbayev',
            'linkedln' => 'https://t.me/akhror.asalbayev',
            'project_completed' => '100',
            'client_satisfied' => '100',
            'design_project' => '100'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('information');
    }
};
