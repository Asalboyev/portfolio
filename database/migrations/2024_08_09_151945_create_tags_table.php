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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('tags')->insert([
            'name' => 'Laravel',
        ]);
        DB::table('tags')->insert([
            'name' => 'Filament',
        ]);
        DB::table('tags')->insert([
            'name' => 'Voyager',
        ]);
        DB::table('tags')->insert([
            'name' => 'Php',
        ]);
        DB::table('tags')->insert([
            'name' => 'Php7',
        ]);
        DB::table('tags')->insert([
        'name' => 'Yill2',
    ]);
        DB::table('tags')->insert([
            'name' => 'Filament',
        ]);
        DB::table('tags')->insert([
            'name' => 'Livewire',
        ]);
        DB::table('tags')->insert([
            'name' => 'Laravel/Filament',
        ]);
        DB::table('tags')->insert([
            'name' => 'Laravel/Livewire',
        ]);
        DB::table('tags')->insert([
            'name' => 'HTML/CSS/JS',
        ]);
        DB::table('tags')->insert([
            'name' => 'React.js',
        ]);
        DB::table('tags')->insert([
            'name' => 'Vue.js',
        ]);
        DB::table('tags')->insert([
            'name' => 'Nuxt2',
        ]);
        DB::table('tags')->insert([
            'name' => 'Nuxt3',
        ]);
        DB::table('tags')->insert([
            'name' => 'Android',
        ]);
        DB::table('tags')->insert([
        'name' => 'Ios',
    ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
