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
        Schema::create('keychains', function (Blueprint $table) {
            $table->comment('Брелки CS2');

            $table->bigInteger('id')->primary()->comment('Идентификатор');

            $table->string('name')->index()->comment('Название');

            $table->string('original_name')->index()->comment('Оригинальное название из файлов CS2');

            $table->string('icon')->comment('Иконка стикера');

            $table->string('rarity_id')->index()->comment('Идентификатор редкости');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keychains');
    }
};
