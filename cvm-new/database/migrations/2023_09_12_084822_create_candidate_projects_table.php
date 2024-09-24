<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
            $table->string('name');
            $table->date('from')->nullable();
            $table->date('to')->nullable();
            $table->unsignedBigInteger('designation_id');
            $table->foreign('designation_id')->references('id')->on('designations')->onDelete('cascade');
            $table->unsignedBigInteger('industry_id')->nullable();
            $table->foreign('industry_id')->references('id')->on('industries')->onDelete('cascade');
            $table->unsignedBigInteger('sector_id')->nullable();
            $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->unsignedBigInteger('phase_id')->nullable();
            $table->foreign('phase_id')->references('id')->on('phases')->onDelete('cascade');
            $table->string('employer_name')->nullable();
            $table->unsignedBigInteger('employer_type_id')->nullable();
            $table->foreign('employer_type_id')->references('id')->on('employer_types')->onDelete('cascade');
            $table->enum('project_type', ['National', 'International']);
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->integer('project_length')->nullable();
            $table->integer('project_cost')->nullable();
            $table->unsignedBigInteger('funding_agency_id')->nullable();
            $table->foreign('funding_agency_id')->references('id')->on('funding_agencies')->onDelete('cascade');
            $table->unsignedBigInteger('contract_mode_id')->nullable();
            $table->foreign('contract_mode_id')->references('id')->on('contract_modes')->onDelete('cascade');
            $table->unsignedBigInteger('terrain_id')->nullable();
            $table->foreign('terrain_id')->references('id')->on('terrains')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade'); // company id is for filter purpose
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('candidate_projects');
    }
}
