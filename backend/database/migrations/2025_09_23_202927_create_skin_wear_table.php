<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const string TABLE_NAME = 'skin_wear';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->id();

            $table->string('skin_name');
            $table->string('wear_id');

            $table->foreign('skin_name')
                ->references('name')
                ->on('skins')
                ->onDelete('cascade');

            $table->foreign('wear_id')
                ->references('id')
                ->on('wears')
                ->onDelete('cascade');

            $table->unique(['skin_name', 'wear_id']);
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
