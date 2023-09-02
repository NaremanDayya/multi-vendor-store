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
        //حيعدل مش ينشئ الجدول عشان هيك schema table not create
        Schema::table('categories', function (Blueprint $table) {
            // $table->timestamp('deleted_at');
            //هما مجهزينه تحت
            // $table->softDeletes()->after('name');//يعني يضيفه بعد عمود الاسم لو ما حددنا بيحطه اخر الجدول
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //حيعدل مش ينشئ الجدول عشان هيك schema table not create
        Schema::table('categories', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
