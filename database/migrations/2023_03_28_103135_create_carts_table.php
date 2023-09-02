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
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();//string بيعطي id مميز  وحجمه كبير يعني مع الوقت ما حنوصل للل limit تبعه
            $table->uuid('cookie_id');// ما حنعملها unique لانه كل المنتجات يلي بالسلة الهم نفس ال cookie_id
            $table->foreignId('user_id')->nullable()
            ->constrained('users', 'id')
            ->cascadeOnDelete();// لو كان اليوزر مش مسجل بالموقع فما حيكون اله user id
            $table->foreignId('product_id')
            ->constrained('products', 'id')
            ->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->json('options')->nullable();//للالوان والخصائص يلي بتتغير للمنتج
            $table->unique(['cookie_id','user_id']);
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
        Schema::dropIfExists('carts');
    }
};
