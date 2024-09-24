<div class="modal-body comment-model">
    <form>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-detail">
                            <span>title</span>
                            <p id="title">{{ $data->title }}</p>
                        </div>
                        <div class="card-detail">
                            <span>Job Category</span>
                            <p id="jobCategory">{{ $data['jobCategory']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Job Sub Category</span>
                            <p id="jobSubCategory">{{ $data['subCategory']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Departmanet</span>
                            <p id="Department">{{ $data['Department']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Skill</span>
                            <p id="skill">
                                @foreach ($data['skills'] as $skill)
                                    {{$skill->Skill->name}},
                                    @endforeach
                            </p>
                        </div>
                        <div class="card-detail">
                            <span>Job Location</span>
                            <p id="jobLocation">
                                @foreach ($data['companyLocations'] as $companyLocation)
                                    {{$companyLocation->Locations->name}},
                                @endforeach
                            </p>
                        </div>
                        <div class="card-detail">
                            <span>Start Date</span>
                            <p id="startDate">{{ $data->start_date}}</p>
                        </div>
                        <div class="card-detail">
                            <span>End Date</span>
                            <p id="endDate">{{ $data->end_date}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Openings</span>
                            <p id="opening">{{ $data->openings}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Job Type</span>
                            <p id="jobType">{{ $data['subCategory']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Experience</span>
                            <p id="experience">{{ $data->experience}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Payment Frequency</span>
                            <p id="paymentFrequency">{{ $data->payment_frequency?$data->payment_frequency:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Maximum Salary</span>
                            <p id="maximunSalary">{{ $data->minimum_salary?$data->minimum_salary:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Minimun Salary</span>
                            <p id="minimunSalary">{{ $data->maximum_salary?$data->maximum_salary:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Starting Salary</span>
                            <p id="startingSalary">{{ $data->starting_salary?$data->starting_salary:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Exact Salary</span>
                            <p id="exactSalary">{{ $data->exact_salary?$data->exact_salary:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Rate</span>
                            <p id="rate">{{ $data->rate?$data->rate:'-'}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Currency</span>
                            <p id="currency">{{ $data['currency']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Education</span>
                            <p id="education">
                                @foreach ($data['education'] as $education)
                                {{ $education->Education->name}}, 
                                @endforeach
                            </p>
                        </div>
                        <div class="card-detail">
                            <span>Description</span>
                            <p id="description">{{ $data->description}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Benefits And Perks</span>
                            <p id="perks">
                                @foreach ( $data['companyPerks'] as $companyPerks)
                                {{ $companyPerks->Perks->name}}, 
                                @endforeach
                            </p>
                        </div>
                        <div class="card-detail">
                            <span>Industry</span>
                            <p id="industry">{{ $data['industry']->name}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Is it a Remote Job?</span>
                            <p id="remoteJob">{{ $data->is_remote_job}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Disclose Salary?</span>
                            <p id="discloseSalary">{{ $data->disclose_salary}}</p>
                        </div><div class="card-detail">
                            <span>Photo</span>
                            <p id="photo">{{ $data->photo}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Upload Resume/CV</span>
                            <p id="resume">{{ $data->resume}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Date of Birth</span>
                            <p id="dob">{{ $data->dob}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Gender</span>
                            <p id="gender">{{ $data->gender}}</p>
                        </div>
                        <div class="card-detail">
                            <span>Show Recruiter</span>
                            <p id="recruiter">{{ $data->show_recruiter}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- ./row -->
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn_style ghost_btn" data-dismiss="modal">
        Close
    </button>
</div>