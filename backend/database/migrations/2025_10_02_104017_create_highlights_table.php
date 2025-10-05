<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected const string TABLE_NAME = 'highlights';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Хайлаты CS2');

            $table->string('original_id')
                ->primary()
                ->comment('Оригинальный идентификатор из файлов CS2');

            $table->bigInteger('id')
                ->index()
                ->comment('Порядоквый номер из списка хайлавтов (для csfloat)');

            $table->bigInteger('tournament_event_id');

            $table->bigInteger('tournament_event_stage_id');

            $table->string('map');

            $table->bigInteger('tournament_event_team0_id');

            $table->bigInteger('tournament_event_team1_id');

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
