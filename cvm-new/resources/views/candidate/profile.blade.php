<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <main class="candidate-profile-wrappper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="title">Profile</div>
            </div>
            <!-- ./title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-profile-wrapper">
                                <div class="profile-candidate">
                                    <div class="card-main-profile">
                                        <img src="{{ ($candidate->profile_image) ? asset('images/candidate/' . $candidate->profile_image) : asset('images/profile.jpg')}}"
                                            width="100" alt="">
                                        <div class="card-profile-product">
                                            <h3>{{ ucfirst($candidate->first_name) . $candidate->last_name }}</h3>
                                            <span>{{ $candidate->email}}</span>
                                        </div>
                                    </div>

                                    <div class="profile-candidate-number">
                                        <div class="profile-candidate-cards">
                                            <div class="profile-candidate-card-icons">
                                                <img src="{{ asset('images/icons/card-layers.png')}}"
                                                    width="25" alt="">
                                            </div>
                                            <div class="profile-candidate-card-conuter">
                                                <h4>{{ $candidate->project->count() }}</h4>
                                                <span>Projects</span>
                                            </div>
                                        </div>
                                        <div class="profile-candidate-cards">
                                            <div class="profile-candidate-card-icons">
                                                <img src="{{ asset('images/icons/filter.png')}}"
                                                    width="25" alt="">
                                            </div>
                                            <div class="profile-candidate-card-conuter">
                                                <h4>{{ $candidate->training->count() }}</h4>
                                                <span>Training</span>
                                            </div>
                                        </div>
                                        <div class="profile-candidate-cards">
                                            <div class="profile-candidate-card-icons">
                                                <img src="{{ asset('images/icons/listss.png')}}"
                                                    width="25" alt="">
                                            </div>
                                            <div class="profile-candidate-card-conuter">
                                                <h4>{{ $candidate->membership->count() }}</h4>
                                                <span>Membership</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="card">
                        <div class="card-header">
                            Profile
                        </div>
                        <div class="card-body">
                            <div class="card-profile-wrapper">
                                <div class="card-profile-container">
                                    <p>Full Name : </p>
                                    <span> {{ ucfirst($candidate->first_name) . $candidate->last_name }}</span>
                                </div>
                                <div class="card-profile-container">
                                    <p>DOB : </p>
                                    <span> {{ $candidate->dob }}</span>
                                </div>
                                <div class="card-profile-container">
                                    <p>Email : </p>
                                    <span> {{ $candidate->email }}</span>
                                </div>
                                <div class="card-profile-container">
                                    <p>Gender : </p>
                                    <span> {{ $candidate->gender }}</span>
                                </div>
                                <div class="card-profile-container">
                                    <p>Phone Number : </p>
                                    <span> {{ $candidate->phone_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Education
                        </div>
                        <div class="card-body">
                            <div class="project-card-container">
                                @forelse ($eduction as $eductionDetail)
                                    <div class="project-details">
                                        <div class="project-link-div">
                                            <h2>{{ $eductionDetail->educationLevel->name }}</h2>
                                            <span>{{ Carbon\Carbon::parse($eductionDetail->from_year)->format('j F')}} - {{ Carbon\Carbon::parse($eductionDetail->to_year)->format('j F') }}</span>
                                        </div>
                                        <div class="project-skills-div">
                                            <h2>Subject :</h2>
                                            <span> {{ ucfirst($eductionDetail->subject->name)}}</span>
                                        </div>
                                        <div class="project-skills-div">
                                            <h2>Specialization :</h2>
                                            <span>{{ $eductionDetail->specialization }} </span>
                                        </div>
                                    </div>
                                @empty
                                    <span class="no_recode">No Record Found.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card">
                        <div class="card-header">
                            Project
                        </div>
                        <div class="card-body">
                            <div class="project-card-container">
                                @forelse ($projects as $project)
                                    <div class="project-details">
                                        <div class="project-link-div">
                                            <h2>{{ $project->name}}</h2>
                                            <span>{{ Carbon\Carbon::parse($project->from)->format('j F')}} - {{ Carbon\Carbon::parse($project->to)->format('j F') }}</span>
                                        </div>
                                        <div class="project-skills-div">
                                            <h2>Designation :</h2>
                                            <span> {{ $project->designation->name}}</span>
                                        </div>
                                        <div class="project-skills-div">
                                            <h2>Description :</h2>
                                            <span>{{ $project->project_type }} project with team of {{ $project->project_length}} members </span>
                                        </div>
                                    </div>
                                @empty
                                <span class="no_recode">No Record Found.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 trainnng-cardss">
                        <div class="card">
                            <div class="card-header">
                                Trainings
                            </div>
                            <div class="card-body">
                                <div class="project-card-container">
                                    @forelse ($trainings as $training )
                                        <div class="project-details">
                                            <h4>{{ $training->certificate->name}} </h4>
                                                <div class="project-skills-div">
                                                    <h2>Duration :</h2>
                                                    <span>{{ $training->duration }} Months</span>
                                                </div>
                                            <div class="project-skills-div">
                                                <h2>Institute/Training Center :</h2>
                                                <span>{{ $training->training_center}}</span>
                                            </div>
                                        </div>
                                    @empty
                                    <span class="no_recode">No Record Found.</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            Memberships
                        </div>
                        <div class="card-body">
                            <div class="project-card-container">
                                @forelse ($membership as $membershipDeatils)
                                    <div class="project-details">
                                        <h4>{{ $membershipDeatils->membership->name}}</h4>
                                        <div class="project-skills-div">
                                            <h2>Membership Type :</h2>
                                            <span>{{ $membershipDeatils->type}}</span>
                                        </div>
                                        <div class="project-skills-div">
                                            <h2>Year :</h2>
                                            <span>{{ $membershipDeatils->year_of_award }}</span>
                                        </div>
                                    </div>
                                @empty
                                <span class="no_recode">No Record Found.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            Keywords
                        </div>
                        <div class="card-body">
                            <div class="keyword-container">
                                @foreach ($keywords as $keyword)
                                    @if (isset($keyword->keyword))
                                    <div class="keyboard-div">{{ $keyword->keyword->keyword}}</div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>