<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)
                ->collation('utf8mb4_0900_ai_ci')
                ->index();
            $table->string('photo', 255);
            $table->decimal('price', 11, 2)
                ->nullable()
                // ->storedAs(
                //     'JSON_UNQUOTE(properties->>"$.price")'
                // )
                ;
            $table->jsonb('properties')
                ->nullable()
                ;
            $table->integer('quantity')
                ->default(0)
            ;
            $table->boolean('available')
                ->default(false)
            ;
            $table->bigInteger('type_id')
                ->unsigned()
            ;
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT')
            ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
