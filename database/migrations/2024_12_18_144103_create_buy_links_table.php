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
        Schema::create('buy_links', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('link');
            $table->decimal('price', 10, 2);
            $table->string('currency');
            $table->unsignedBigInteger('component_id');
            $table->unsignedBigInteger('delivery_group_id')->nullable();
            $table->timestamps();

            $table->foreign('component_id')->references('id')->on('components');
            $table->foreign('delivery_group_id')->references('id')->on('delivery_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_links');
    }
};
