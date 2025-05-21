<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('subscriptions');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2); // Harga
            $table->decimal('discount_extend', 5, 2)->nullable(); // Diskon perpanjangan
            $table->decimal('discount_upgrade', 5, 2)->nullable(); // Diskon upgrade plan
            $table->integer('extra_days')->nullable(); // Tambahan hari
            $table->timestamps();
        });
    }

};
