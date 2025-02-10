<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchAssistantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research_assistants', function (Blueprint $table) {
            $table->id();
            $table->string('group_name_th');
            $table->string('group_name_en');
            $table->string('research_title_th');
            $table->string('research_title_en');
            $table->integer('members_count');
            $table->string('form_link');



            $table->unsignedBigInteger('degree_id'); // FK ไปยังตาราง degrees
            $table->unsignedBigInteger('research_group_id'); // FK ไปยัง research_groups
            $table->unsignedBigInteger('project_id')->nullable();

            $table->timestamps();


            // Foreign key constraint
            $table->foreign('research_group_id')->references('id')->on('research_groups')->onDelete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees')->onDelete('cascade');

            $table->foreign('project_id')->references('id')->on('research_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('research_assistants');
    }
    
}
