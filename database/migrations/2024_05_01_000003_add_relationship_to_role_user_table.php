<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id')->nullable()->index('idx_role_id');
            $table->foreign('role_id', 'fk_role_id_id_002')->references('id')->on('roles')->constrained()->onDelete('cascade');
            
            $table->unsignedInteger('user_id')->nullable()->index('idx_user_id');
            $table->foreign('user_id', 'fk_user_id_id_001')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('created_by')->nullable()->index('idx_created_by');
            $table->foreign('created_by', 'fk_created_by_id_005')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('updated_by')->nullable()->index('idx_updated_by');
            $table->foreign('updated_by', 'fk_updated_by_id_005')->references('id')->on('users')->constrained()->onDelete('cascade');

            $table->unsignedInteger('deleted_by')->nullable()->index('idx_deleted_by');
            $table->foreign('deleted_by', 'fk_deleted_by_id_005')->references('id')->on('users')->constrained()->onDelete('cascade');
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
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign('fk_role_id_id_002');
            $table->dropIndex('idx_role_id');
            $table->dropColumn('role_id');

            $table->dropForeign('fk_user_id_id_001');
            $table->dropIndex('idx_user_id');
            $table->dropColumn('user_id');

            $table->dropForeign('fk_created_by_id_005');
            $table->dropIndex('idx_created_by');
            $table->dropColumn('created_by');

            $table->dropForeign('fk_updated_by_id_005');
            $table->dropIndex('idx_updated_by');
            $table->dropColumn('updated_by');

            $table->dropForeign('fk_deleted_by_id_005');
            $table->dropIndex('idx_deleted_by');
            $table->dropColumn('deleted_by');
        });
    }
};
