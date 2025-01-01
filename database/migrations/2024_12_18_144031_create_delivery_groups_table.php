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
        Schema::create('delivery_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->decimal('free_delivery_at', 10, 2)->nullable();
            $table->decimal('delivery_cost', 10, 2);
            $table->unsignedBigInteger('build_id')->nullable();
            $table->string('currency');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('build_id')->references('id')->on('builds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_groups');
    }
};
