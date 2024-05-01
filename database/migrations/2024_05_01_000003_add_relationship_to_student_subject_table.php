<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('student_subject', function (Blueprint $table) {
            $table->unsignedInteger('student_id')->nullable()->index('idx_student_id');
            $table->foreign('student_id', 'fk_student_id_id_001')->references('id')->on('employees')->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('subject_id')->nullable()->index('idx_subject_id');
            $table->foreign('subject_id', 'fk_subject_id_id_002')->references('id')->on('subjects')->constrained()->onDelete('cascade');

            $table->unsignedInteger('created_by')->nullable()->index('idx_created_by');
            $table->foreign('created_by', 'fk_created_by_id_020')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('updated_by')->nullable()->index('idx_updated_by');
            $table->foreign('updated_by', 'fk_updated_by_id_020')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('deleted_by')->nullable()->index('idx_deleted_by');
            $table->foreign('deleted_by', 'fk_deleted_by_id_020')->references('id')->on('users')->constrained()->onDelete('cascade');
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('student_subject', function (Blueprint $table) {
            $table->dropForeign('fk_student_id_id_001');
            $table->dropIndex('idx_student_id');
            $table->dropColumn('student_id');

            $table->dropForeign('fk_subject_id_id_002');
            $table->dropIndex('idx_subject_id');
            $table->dropColumn('subject_id');

            $table->dropForeign('fk_created_by_id_020');
            $table->dropIndex('idx_created_by');
            $table->dropColumn('created_by');

            $table->dropForeign('fk_updated_by_id_020');
            $table->dropIndex('idx_updated_by');
            $table->dropColumn('updated_by');

            $table->dropForeign('fk_deleted_by_id_020');
            $table->dropIndex('idx_deleted_by');
            $table->dropColumn('deleted_by');
        });
    }
};
