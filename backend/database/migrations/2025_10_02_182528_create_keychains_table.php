<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const string TABLE_NAME = 'keychains';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Брелки CS2');

            $table->string('original_name')
                ->primary()
                ->comment('Оригинальное название из файлов CS2');

            $table->string('name')
                ->index()
                ->comment('Название');

            $table->bigInteger('id')
                ->unique()
                ->nullable()
                ->index()
                ->comment('Идентификатор (индекс из списка брелков CS2)');

            $table->string('icon', 512)
                ->comment('Иконка брелка');

            $table->string('rarity_id')
                ->index()
                ->comment('Идентификатор редкости');

            $table->boolean('is_highlight')
                ->comment('Брелок - хайлайт');

            $table->bigInteger('highlight_id')
                ->unique()
                ->nullable()
                ->index()
                ->comment('Идентификатор хайлайта');

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
