<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable()->index('idx_role_id');
            $table->foreign('role_id', 'fk_role_id_id_001')->references('id')->on('roles')->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('permission_id')->nullable()->index('idx_permission_id');
            $table->foreign('permission_id', 'fk_permission_id_id_001')->references('id')->on('permissions')->constrained()->onDelete('cascade');

            $table->unsignedInteger('created_by')->nullable()->index('idx_created_by');
            $table->foreign('created_by', 'fk_created_by_id_004')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('updated_by')->nullable()->index('idx_updated_by');
            $table->foreign('updated_by', 'fk_updated_by_id_004')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('deleted_by')->nullable()->index('idx_deleted_by');
            $table->foreign('deleted_by', 'fk_deleted_by_id_004')->references('id')->on('users')->constrained()->onDelete('cascade');
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
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('fk_role_id_id_001');
            $table->dropIndex('idx_role_id');
            $table->dropColumn('role_id');

            $table->dropForeign('fk_permission_id_id_001');
            $table->dropIndex('idx_permission_id');
            $table->dropColumn('permission_id');

            $table->dropForeign('fk_created_by_id_004');
            $table->dropIndex('idx_created_by');
            $table->dropColumn('created_by');

            $table->dropForeign('fk_updated_by_id_004');
            $table->dropIndex('idx_updated_by');
            $table->dropColumn('updated_by');

            $table->dropForeign('fk_deleted_by_id_004');
            $table->dropIndex('idx_deleted_by');
            $table->dropColumn('deleted_by');
        });
    }
};
