<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const string TABLE_NAME = 'lots_history';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('История изменения лотов');

            $table->id();

            $table->bigInteger('lot_id')->comment('Идентификатор лота');

            $table->jsonb('before')->comment('До изменений');

            $table->jsonb('changes')->comment('Изменения');

            $table->index('lot_id');
            $table->foreign('lot_id')->references('a')->on('lots');

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
