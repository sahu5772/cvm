<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable()->after('profile_picture');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->unsignedBigInteger('department_id')->nullable()->after('designation_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('reporting_to')->nullable()->after('department_id');
            $table->foreign('reporting_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->after('reporting_to');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('business_unit_id')->nullable();
            $table->foreign('business_unit_id')->references('id')->on('business_units')->onDelete('cascade')->after('company_id');
            $table->enum('is_active',['Active', 'Inactive'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
