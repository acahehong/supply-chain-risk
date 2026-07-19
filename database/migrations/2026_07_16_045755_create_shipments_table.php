<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {

            $table->id();

            $table->string('tracking_code')->unique();

            $table->foreignId('origin_port_id')
                  ->constrained('ports')
                  ->cascadeOnDelete();

            $table->foreignId('destination_port_id')
                  ->constrained('ports')
                  ->cascadeOnDelete();

            $table->date('departure_date');

            $table->date('eta');

            $table->integer('progress')->default(0);

            $table->integer('delay_days')->default(0);

            $table->enum('status',[
                'On Schedule',
                'Possible Delay',
                'Delayed',
                'Delivered'
            ])->default('On Schedule');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};