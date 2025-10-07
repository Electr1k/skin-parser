<?php

use App\Enums\Extremum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const string TABLE_NAME = 'skin_settings';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Таблица с параметрами скинов для поиска');

            $table->string('name')
                ->primary()
                ->comment('Название скина для поиска');

            $table
                ->float('max_price')
                ->comment('Максимальная цена для поиска');

            $table
                ->boolean('is_active')
                ->default(true)
                ->comment('Активен ли поиск');

            $table
                ->float('float_limit')
                ->nullable()
                ->comment('Пороговое значение float');

            $table
                ->enum('extremum', Extremum::cases())
                ->nullable()
                ->comment('Предел, к которому стримится float (MIN, MAX)');

            $table
                ->float('min_stickers_price')
                ->nullable()
                ->comment('Минимальная стоимость стикеров');

            $table
                ->float('min_keychains_price')
                ->nullable()
                ->comment('Минимальная стоимость брелков');

            $table->timestamps();
        });

        // Если установлен float_limit, то extremum IS NOT NULL
        DB::statement("
            ALTER TABLE " . self::TABLE_NAME . "
            ADD CONSTRAINT float_limit_extremum_consistency_check
            CHECK (
                (float_limit IS NULL AND extremum IS NULL) OR
                (float_limit IS NOT NULL AND extremum IS NOT NULL)
            )
        ");

        // Установлена хотя бы одна проверка
        DB::statement("
            ALTER TABLE " . self::TABLE_NAME . "
            ADD CONSTRAINT at_least_one_search_condition_check
            CHECK (
                (float_limit IS NOT NULL AND extremum IS NOT NULL) OR
                min_stickers_price IS NOT NULL OR
                min_keychains_price IS NOT NULL
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
