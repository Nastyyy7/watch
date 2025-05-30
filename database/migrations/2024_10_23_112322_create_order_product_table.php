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
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')
                ->default(0)
            ;
            $table->jsonb('properties')
            ->nullable()
            ;
            $table->bigInteger('order_id')
                ->unsigned()
            ;
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT')
            ;
            $table->bigInteger('product_id')
                ->unsigned()
            ;
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('CASCADE')
                ->onUpdate('RESTRICT')
            ;
            $table->unique(['order_id', 'product_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product');
    }
};
