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
            $table->string('name', 50);
            $table->float('price_kg');
            $table->string('material', 50);
            $table->date('production_time');
            $table->timestamps();
        });
        DB::table('products')->insert(array('id'=>'1','name'=>'téliszalámi','price_kg'=> '7270.12','material'=>'sertés','production_time'=>'2022-02-09','created_at'=>'2022-02-11 18:00:00','updated_at'=>'2022-02-11 18:00:00'));
        DB::table('products')->insert(array('id'=>'2','name'=>'hazai parasztkolbász','price_kg'=> '6580.667','material'=>'sertés','production_time'=>'2022-02-10','created_at'=>'2022-02-11 18:00:00','updated_at'=>'2022-02-11 18:00:00'));
        DB::table('products')->insert(array('id'=>'3','name'=>'hazai lókolbász','price_kg'=> '9980.7','material'=>'ló','production_time'=>'2022-02-10','created_at'=>'2022-02-11 18:00:00','updated_at'=>'2022-02-11 18:00:00'));
        DB::table('products')->insert(array('id'=>'4','name'=>'marha párizsi','price_kg'=> '3340.46','material'=>'marha','production_time'=>'2022-02-11','created_at'=>'2022-02-11 18:00:00','updated_at'=>'2022-02-11 18:00:00'));
        DB::table('products')->insert(array('id'=>'5','name'=>'marha szalámi (rúd)','price_kg'=> '6987.34','material'=>'marha','production_time'=>'2022-02-11','created_at'=>'2022-02-11 18:00:00','updated_at'=>'2022-02-11 18:00:00'));
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
