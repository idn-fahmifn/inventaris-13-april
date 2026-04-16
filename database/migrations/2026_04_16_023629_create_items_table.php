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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()
            ->constrained('locations')->nullOnDelete();
            $table->string('name');
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);
            $table->enum('condition', ['new', 'good', 'broke', 'maintenance'])->default('good');    
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
