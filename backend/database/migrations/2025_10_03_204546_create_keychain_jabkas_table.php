<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private const string TABLE_NAME = 'keychains_jabka';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Таблица цен брелков jabka.skin');

            $table->bigInteger('id')->primary()->comment('Идентификатор');

            $table->string('name')->comment('Название');

            $table->float('price',2)->comment('Цена в стиме');

            $table->float('price_jabka', 2)->comment('Цена на jabka.skin');

            $table->jsonb('colors')->nullable()->comment('Цвета брелка');

            $table->string('icon')->comment('Иконка брелка');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keychain_jabkas');
    }
};
