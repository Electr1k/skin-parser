<?php

use App\Enums\Extremum;
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
        Schema::create('search_settings', function (Blueprint $table) {
            $table->comment('Таблица с параметрами скинов для поиска');

            $table->string('id')
                ->primary()
                ->comment('Идентификатор (slug) скина для поиска');

            $table->string('market_hash_name')
                ->unique()
                ->comment('Название скина на латинице');

            $table
                ->string('market_name')
                ->unique()
                ->comment('Название скина на кириллице');

            $table
                ->string('icon')
                ->comment('Иконка скина')
                ->nullable();

            $table
                ->enum('extremum', Extremum::cases())
                ->comment('Предел, к которому стримится float (MIN, MAX)');

            $table
                ->float('float_limit')
                ->comment('Пороговое значение float');

            $table
                ->float('max_price')
                ->comment('Максимальная цена для поиска');

            $table
                ->boolean('is_active')
                ->default(true)
                ->comment('Активен ли поиск');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ыл_search_settings');
    }
};
