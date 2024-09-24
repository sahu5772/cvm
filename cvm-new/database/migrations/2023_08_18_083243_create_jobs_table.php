<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            $table->unsignedBigInteger('job_category_id');
            $table->foreign('job_category_id')->references('id')->on('job_categories')->onDelete('cascade');

            $table->unsignedBigInteger('job_sub_category_id');
            $table->foreign('job_sub_category_id')->references('id')->on('job_sub_categories')->onDelete('cascade');

            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('openings')->nullable();

            $table->unsignedBigInteger('job_type_id');
            $table->foreign('job_type_id')->references('id')->on('job_types')->onDelete('cascade');

            $table->string('experience')->nullable();

            $table->unsignedBigInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');

            $table->enum('payment_frequency', ['range', 'starting salary', 'maximum salary', 'exact salary'])->nullable();
            $table->bigInteger('minimum_salary')->nullable();
            $table->bigInteger('maximum_salary')->nullable();
            $table->bigInteger('starting_salary')->nullable();
            $table->bigInteger('exact_salary')->nullable();
            $table->enum('rate', ['hour', 'day', 'week', 'month', 'year'])->nullable();
            $table->enum('is_remote_job',['Yes', 'No'])->default('No');
            $table->enum('disclose_salary',['Yes', 'No'])->default('No');
            $table->text('description')->nullable();
            $table->enum('photo',['Required', 'Not Required'])->default('Not Required');
            $table->enum('resume',['Required', 'Not Required'])->default('Not Required');
            $table->enum('dob',['Required', 'Not Required'])->default('Not Required');
            $table->enum('gender',['Required', 'Not Required'])->default('Not Required');
            $table->enum('status',['Open', 'Closed'])->default('Open');
            $table->enum('show_recruiter',['Yes', 'No'])->default('Yes');
            $table->unsignedBigInteger('industry_id');
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');

            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->enum('is_active',['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('jobs');
    }
}
