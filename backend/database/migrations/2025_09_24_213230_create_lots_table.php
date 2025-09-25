<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const string TABLE_NAME = 'lots';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Таблица лотов');

            $table->bigInteger('a')->primary();

            $table->string('d');

            $table->string('m');

            $table->string('skin_id')->comment('Идентификатор скина');

            $table->float('price', 2)->nullable()->default(null)->comment('Цена');

            $table->float('float')->nullable()->default(null)->comment('Float');

            $table->jsonb('stickers')->nullable()->default(null)->comment('Стикеры');

            $table->unsignedSmallInteger('page')->comment('Номер страницы, на которой находился лот');

            $table->string('custom_name')->nullable()->default(null)->comment('Наймтег');

            $table->string('price_dirty')->comment('Цена до нормализации');

            $table->string('inspect_link')->comment('Ссылка на осмотр');

            $table->index('skin_id', 'float');

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
