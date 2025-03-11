<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePapersTable extends Migration
{
    public function up()
    {
        Schema::table('papers', function (Blueprint $table) {
            // เพิ่ม abstract ถ้ายังไม่มี
            if (!Schema::hasColumn('papers', 'abstract')) {
                $table->text('abstract')->nullable()->after('paper_doi');
            }
            // อัพเดท keywords ให้เป็น json ถ้ายังไม่ใช่
            if (Schema::hasColumn('papers', 'keyword')) {
                $table->dropColumn('keyword');
            }
            if (!Schema::hasColumn('papers', 'keywords')) {
                $table->json('keywords')->nullable()->after('abstract');
            }
        });
    }

    public function down()
    {
        Schema::table('papers', function (Blueprint $table) {
            $table->dropColumn('abstract');
            $table->dropColumn('keywords');
            $table->string('keyword')->nullable()->after('paper_doi'); // คืนค่า keyword ถ้า rollback
        });
    }
}
