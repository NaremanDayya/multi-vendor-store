 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{


    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            //id BIGINT UNSIGNED AUTO_INCEMENT PK
            //$table->bigInteger('id')->unsigned()->autoIncrement()->primary();// idهي اختصار لمعنى  
            //$table->unsignedBgInteger('id')->()autoIncrement()->primary();
            //$table->bigIncrements('id'); 
            //$table->uuid();//unautoincrement id ,not number &not any string ,ex:123e68n65

            $table->id();
            $table->string('name');//VARCHAR(64000,..)
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('cover_image')->nullable();
            $table->enum('status' ,['active','inactive'])->default('active');
            // $table->id('store_id')->constraint();
            $table->timestamps();//created_at, updated_at
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
