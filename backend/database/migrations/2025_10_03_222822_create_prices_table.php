<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    private const string TABLE_NAME = 'prices';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->comment('Цены на скины');

            $table->string('name')->primary();

            $table->float('last_24h', 3)
                ->nullable()
                ->comment('Медианная цена за 24ч в Steam');

            $table->float('last_7d', 3)
                ->nullable()
                ->comment('Медианная цена за 7д в Steam');

            $table->float('last_30d', 3)
                ->nullable()
                ->comment('Медианная цена за 30д в Steam');

            $table->float('last_90d', 3)
                ->nullable()
                ->comment('Медианная цена за 90д в Steam');

            $table->float('last_ever', 3)
                ->nullable()
                ->comment('Медианная цена за все время в Steam');

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
