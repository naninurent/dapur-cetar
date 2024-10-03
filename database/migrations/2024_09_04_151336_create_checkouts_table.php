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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('no_order');
            $table->integer('total_qty');
            $table->integer('total_harga');
            $table->string('snap_token');
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('no_order')->references('no_order')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
