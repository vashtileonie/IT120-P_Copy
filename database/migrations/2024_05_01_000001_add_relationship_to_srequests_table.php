<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('srequests', function (Blueprint $table) {
            $table->unsignedInteger('form_type_id')->nullable()->index('idx_form_type_id');
            $table->foreign('form_type_id', 'fk_form_type_id_id_001')->references('id')->on('form_types')->constrained()->onDelete('cascade');

            $table->unsignedInteger('latest_request_status_id')->nullable()->index('idx_latest_request_status_id');
            $table->foreign('latest_request_status_id', 'fk_latest_request_status_id_id_001')->references('id')->on('srequest_statuses')->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('advising_type_id')->nullable()->index('idx_advising_type_id');
            $table->foreign('advising_type_id', 'fk_advising_type_id_id_001')->references('id')->on('advising_types')->constrained()->onDelete('cascade');

            $table->unsignedInteger('priority_id')->nullable()->index('idx_priority_id');
            $table->foreign('priority_id', 'fk_priority_id_id_001')->references('id')->on('priorities')->constrained()->onDelete('cascade');

            $table->unsignedInteger('student_id')->nullable()->index('idx_student_id');
            $table->foreign('student_id', 'fk_student_id_id_002')->references('id')->on('students')->constrained()->onDelete('cascade');

            $table->unsignedInteger('employee_id')->nullable()->index('idx_employee_id');
            $table->foreign('employee_id', 'fk_employee_id_id_004')->references('id')->on('employees')->constrained()->onDelete('cascade');

            $table->unsignedInteger('created_by')->nullable()->index('idx_created_by');
            $table->foreign('created_by', 'fk_created_by_id_019')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('updated_by')->nullable()->index('idx_updated_by');
            $table->foreign('updated_by', 'fk_updated_by_id_019')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('deleted_by')->nullable()->index('idx_deleted_by');
            $table->foreign('deleted_by', 'fk_deleted_by_id_019')->references('id')->on('users')->constrained()->onDelete('cascade');
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
        Schema::table('srequests', function (Blueprint $table) {
            $table->dropForeign('fk_form_type_id_id_001');
            $table->dropIndex('idx_form_type_id');
            $table->dropColumn('form_type_id');

            $table->dropForeign('fk_latest_request_status_id_id_001');
            $table->dropIndex('idx_latest_request_status_id');
            $table->dropColumn('latest_request_status_id');

            $table->dropForeign('fk_advising_type_id_id_001');
            $table->dropIndex('idx_advising_type_id');
            $table->dropColumn('advising_type_id');

            $table->dropForeign('fk_priority_id_id_001');
            $table->dropIndex('idx_priority_id');
            $table->dropColumn('priorities');

            $table->dropForeign('fk_student_id_id_002');
            $table->dropIndex('idx_student_id');
            $table->dropColumn('students');

            $table->dropForeign('fk_employee_id_id_004');
            $table->dropIndex('idx_employee_id');
            $table->dropColumn('employee_id');

            $table->dropForeign('fk_created_by_id_019');
            $table->dropIndex('idx_created_by');
            $table->dropColumn('created_by');

            $table->dropForeign('fk_updated_by_id_019');
            $table->dropIndex('idx_updated_by');
            $table->dropColumn('updated_by');

            $table->dropForeign('fk_deleted_by_id_019');
            $table->dropIndex('idx_deleted_by');
            $table->dropColumn('deleted_by');
        });
    }
};
