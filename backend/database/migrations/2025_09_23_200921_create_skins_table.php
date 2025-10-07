<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const string TABLE_NAME = 'skins';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Скины CS2');

            $table->string('name')
                ->primary()
                ->comment('Название скина на латинице');

            $table->string('ru_name')
                ->index()
                ->comment('Название скина на кириллице');

            $table->float('min_float')
                ->nullable()
                ->comment('Минимальное значение float');

            $table->float('max_float')
                ->nullable()
                ->comment('Максимальное значение float');

            $table->string('icon')
                ->comment('Иконка скина');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
