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
          Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name'); 
                $table->text('description'); 
                $table->string('image'); 
                $table->decimal('price', 10, 2); 
                $table->decimal('price_after', 10, 2)->nullable(); 
                $table->integer('stock'); 
                $table->unsignedBigInteger('category_id')->nullable(); 
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
 
                $table->timestamps();
            });   
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
