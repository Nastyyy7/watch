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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->text('content')
                ->nullable()
            ;
            $table->smallInteger('rating');
            $table->bigInteger('order_product_id')
                ->unsigned()
            ;
            $table->foreign('order_product_id')
                ->references('id')
                ->on('order_product')
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
        Schema::dropIfExists('reviews');
    }
};
