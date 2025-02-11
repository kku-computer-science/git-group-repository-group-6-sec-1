<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchAssistantsTable extends Migration
{
    public function up()
    {
        Schema::create('research_assistants', function (Blueprint $table) {
            $table->id();
            $table->integer('member_count');
            $table->unsignedBigInteger('project_id'); 
            $table->unsignedBigInteger('group_id'); // แก้จาก research_group_id เป็น group_id
            $table->unsignedBigInteger('research_group_id');
            $table->string('group_name_th', 255);
            $table->string('group_name_en', 255);

            // กำหนด Foreign Keys ตามโครงสร้างฐานข้อมูล
            $table->foreign('project_id')->references('id')->on('research_projects')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('research_groups')->onDelete('cascade');
            $table->foreign('research_group_id')->references('id')->on('research_groups')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_assistants');
    }
}
