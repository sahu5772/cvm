<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->unsignedBigInteger('candidate_id');
            $table->foreign('candidate_id')->references('id')->on('candidates')->onDelete('cascade');
            $table->unsignedBigInteger('interviewer_id');
            $table->foreign('interviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('interview_round_id');
            $table->foreign('interview_round_id')->references('id')->on('interview_rounds')->onDelete('cascade');
            $table->enum('interview_type', ['Phone', 'Video', 'In Person'])->default('In Person');
            $table->date('interview_on');
            $table->time('start_time');
            $table->text('comment_for_interviewer')->nullable();
            $table->enum('notify_candidate', ['Yes', 'No'])->default('yes');
            $table->text('comment_for_candidate')->nullable();
            $table->decimal('rating', 5,2)->nullable();
            $table->text('zoom_link')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Hired', 'Rejected', 'Completed', 'Canceled'])->default('Pending');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('interview_schedules');
    }
}
