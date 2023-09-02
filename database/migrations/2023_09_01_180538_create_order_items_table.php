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
        //جدول وسيط فمفروض اسمه order-product فبدنا نعرفه بال relation
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
            ->constrained()
            ->cascadeOnDelete();
            $table->foreignId('product_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();//لو حدفوا المنتج من المتجر واحتاجو احصائيات مالية مثلا
            $table->string('product_name');//لو غيروا اسم المنتج في المستقبل 
            $table->float('price');//لو غيروا السعر كمان
            $table->unsignedSmallInteger('quantity')
            ->default(1);
            $table->json('options')->nullable();
            $table->unique(['order_id','product_id']);//هنا معناها انه الاتنين مع بعض ما بينفع يتكرروا مش كل واحد على حدا
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
