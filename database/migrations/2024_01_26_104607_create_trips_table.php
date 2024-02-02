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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('op_id');
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('route_id');
            $table->timestamps();

            $table->foreign('op_id')->references('id')->on('users');
            $table->foreign('route_id')->references('id')->on('routes');
            $table->foreign('bus_id')->references('id')->on('buses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
