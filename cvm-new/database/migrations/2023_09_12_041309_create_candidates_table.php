<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id()->index();
            $table->string('first_name')->index();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->index();
            $table->enum('gender', ['Male', 'Female', 'Other'])->index();
            $table->date('dob')->index();
            $table->unsignedBigInteger('phone_number');
            $table->unsignedBigInteger('language_known')->index(); // Nationality
            $table->foreign('language_known')->references('id')->on('languages')->onDelete('cascade')->index();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('aadhar_card')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('otp')->nullable();
            $table->enum('is_email_verified', ['0', '1'])->default('0')->index();
            $table->enum('is_mobile_verified', ['0', '1'])->default('0')->index();
            $table->integer('total_experience')->default('0')->index();
            $table->unsignedBigInteger('designation_id')->index();
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('country_id'); // Nationality
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum('is_active', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates');
    }
}
