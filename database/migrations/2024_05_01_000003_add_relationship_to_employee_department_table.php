<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employee_department', function (Blueprint $table) {
            $table->unsignedInteger('employee_id')->nullable()->index('idx_employee_id');
            $table->foreign('employee_id', 'fk_employee_id_id_003')->references('id')->on('employees')->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('department_id')->nullable()->index('idx_department_id');
            $table->foreign('department_id', 'fk_department_id_id_001')->references('id')->on('subjects')->constrained()->onDelete('cascade');

            $table->unsignedInteger('created_by')->nullable()->index('idx_created_by');
            $table->foreign('created_by', 'fk_created_by_id_017')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('updated_by')->nullable()->index('idx_updated_by');
            $table->foreign('updated_by', 'fk_updated_by_id_017')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('deleted_by')->nullable()->index('idx_deleted_by');
            $table->foreign('deleted_by', 'fk_deleted_by_id_017')->references('id')->on('users')->constrained()->onDelete('cascade');
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
        Schema::table('employee_department', function (Blueprint $table) {
            $table->dropForeign('fk_employee_id_id_003');
            $table->dropIndex('idx_employee_id');
            $table->dropColumn('employee_id');

            $table->dropForeign('fk_department_id_id_001');
            $table->dropIndex('idx_department_id');
            $table->dropColumn('department_id');

            $table->dropForeign('fk_created_by_id_017');
            $table->dropIndex('idx_created_by');
            $table->dropColumn('created_by');

            $table->dropForeign('fk_updated_by_id_017');
            $table->dropIndex('idx_updated_by');
            $table->dropColumn('updated_by');

            $table->dropForeign('fk_deleted_by_id_017');
            $table->dropIndex('idx_deleted_by');
            $table->dropColumn('deleted_by');
        });
    }
};
