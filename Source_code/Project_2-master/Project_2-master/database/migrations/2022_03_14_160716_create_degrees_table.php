<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<< HEAD
=======
        if (!Schema::hasTable('degrees')) {
>>>>>>> origin/Prommin_1406
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree_name_th');
            $table->string('degree_name_en');
            /*$table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');*/

<<<<<<< HEAD
            $table->unsignedBigInteger('department_id')->nullable();  
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            
            $table->timestamps();
        });
=======
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->timestamps();
        });
        }

>>>>>>> origin/Prommin_1406
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('degrees');
    }
}
