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
<<<<<<< HEAD:Source_code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
<<<<<<< HEAD
=======
        if (!Schema::hasTable('degrees')) {
>>>>>>> origin/Prommin_1406
=======
        if (!Schema::hasTable('degrees')) {
>>>>>>> Bodin_1359:Source_Code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('degree_name_th');
            $table->string('degree_name_en');
            /*$table->unsignedBigInteger('program_id');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');*/

<<<<<<< HEAD:Source_code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
<<<<<<< HEAD
            $table->unsignedBigInteger('department_id')->nullable();  
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            
            $table->timestamps();
        });
=======
=======
>>>>>>> Bodin_1359:Source_Code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
            $table->unsignedBigInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->timestamps();
        });
        }

<<<<<<< HEAD:Source_code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
>>>>>>> origin/Prommin_1406
=======
>>>>>>> Bodin_1359:Source_Code/Project_2-master/Project_2-master/database/migrations/2022_03_14_160716_create_degrees_table.php
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
