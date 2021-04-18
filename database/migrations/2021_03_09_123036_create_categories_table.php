<?php

use App\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $categories = ['Motori' , 'Sport' , 'Elettrodomestici' , 'Libri' , 'Giochi' , 'Abbigliamento' , 'Arredamento' , 'Immobili' , 'Strumenti' , 'Informatica' , 'Affitti'];

        foreach($categories as $category) {
                $c = new Category();
                $c->name = $category;
                $c->save();
        }
    }


    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
