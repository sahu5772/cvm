@extends('layouts.app')
@section('content')

<main class="viewCandidate_wrapper">
    <section class="inner__wrapper">
    <div class="container print">
                <div class="title-candidate-wrapper">
                    <div class="title-sub-headings">
                        <div class="title">{{ $candidate->first_name }}</div>
                        <span>{{ $candidate->email }}</span>
                    </div>
                    <div class="buttons-details-cont">
                        <button onclick="uploadCv({{ $candidate->id }})" class="btn_style ghost_btn dropbtn">
                            <img src="{{ asset('images/icons/download_2989976.png')}}"  alt="" width="15" />Upload CV
                        </button>
                        @if (auth()->user()->hasPermissionTo('cv pdf.download'))
                            @if (auth()->user()->hasRole('super-admin'))
                                <button onclick="myFunctionDrop()" class="btn_style ghost_btn dropbtn">
                                    <img src="{{ asset('images/icons/download_2989976.png')}}"  alt="" width="15" />Uploaded CV
                                </button>
                                <div id="myDropdownfunction" class="dropdown-content">
                                    @foreach ($candidate['cvs'] as $cv)
                                        <a href="{{ route('candidate-cv.show', $cv->id) }}">{{ $cv->file }}</a>
                                    @endforeach
                                </div>
                            @else
                                @php $latestCv = $candidate['cvs']->sortByDesc('created_at')->first(); @endphp
                                @if ($latestCv)
                                    <button onclick="myFunctionDrop()" class="btn_style ghost_btn dropbtn">
                                        <img src="{{ asset('images/icons/download_2989976.png')}}"  alt="" width="15" />Uploaded CV
                                    </button>
                                    <div id="myDropdownfunction" class="dropdown-content">
                                    <a href="{{ route('candidate-cv.show', $latestCv->id) }}">{{ $latestCv->file }}</a>
                                    </div>
                                @endif
                            @endif
                        @endif
                        @if (auth()->user()->hasPermissionTo('print.print'))
                        <button class="btn_style ghost_btn" onclick="printPage()">
                        <img src="{{ asset('images/icons/layers.png')}}" alt="" width="15" />Print</button>
                        @endif

                        <button class="btn_style ghost_btn" onclick="candidateComment({{ $candidate->id }})">
                            <img src="{{ asset('images/icons/diploma.png')}}" alt="" width="15" />Add/View Comment</button>
                            <div class="dropdown">
                            @if (auth()->user()->hasPermissionTo('download cv.download'))
                            <button onclick="myFunctionDrop()" class="btn_style ghost_btn dropbtn">
                                <img src="{{ asset('images/icons/download_2989976.png')}}" alt=""
                                    width="15" />Download</button>
                            @endif
                            <div id="myDropdownfunction" class="dropdown-content">
                                <a href="{{ route('formate', [$candidate->id, '1']) }}">1</a>
                                <a href="{{ route('formate', [$candidate->id, '2']) }}">2</a>
                                <a href="{{ route('formate', [$candidate->id, '3']) }}">3</a>
                                <a href="{{ route('formate', [$candidate->id, '4']) }}">4</a>
                                <a href="{{ route('formate', [$candidate->id, '5']) }}">5</a>
                                <a href="{{ route('formate', [$candidate->id, '6']) }}">6</a>
                                <a href="{{ route('formate', [$candidate->id, '7']) }}">7</a>
                                <a href="{{ route('formate', [$candidate->id, '8']) }}">8</a>
                                <a href="{{ route('formate', [$candidate->id, '9']) }}">9</a>
                                <a href="{{ route('formate', [$candidate->id, '10']) }}">10</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container-fluid card-headered pro">
            <div class="row">
                <div class="col-sm-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active first-border" id="pills-profile-tab" data-toggle="pill"
                                data-target="pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="true">
                                Profile
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-personal-tab" data-toggle="pill"
                                data-target="pills-personal" type="button" role="tab"
                                aria-controls="pills-personal" aria-selected="false">
                                {{ __('messages.candidate.personal_details')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-educational-tab" data-toggle="pill"
                                data-target="pills-educational" type="button" role="tab"
                                aria-controls="pills-educational" aria-selected="false">
                                {{ __('messages.candidate.educational_details')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-professional-tab" data-toggle="pill"
                                data-target="pills-professional" type="button" role="tab"
                                aria-controls="pills-professional" aria-selected="false">
                                {{ __('messages.candidate.professional_details')}}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-project-tab" data-toggle="pill"
                                data-target="pills-project" type="button" role="tab" aria-controls="pills-project"
                                aria-selected="false">
                                Project Details
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-training-tab" data-toggle="pill"
                                data-target="pills-training" type="button" role="tab"
                                aria-controls="pills-training" aria-selected="false">
                                Training
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-member-tab" data-toggle="pill"
                                data-target="pills-member" type="button" role="tab" aria-controls="pills-member"
                                aria-selected="false">
                                Membership
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-address-tab" data-toggle="pill"
                                data-target="pills-address" type="button" role="tab" aria-controls="pills-address"
                                aria-selected="false">
                                Address
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link second-border" id="pills-keywords-tab" data-toggle="pill"
                                data-target="pills-keywords" type="button" role="tab"
                                aria-controls="pills-keywords" aria-selected="false">
                                Add Keywords
                            </button>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- ./row -->
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="viewCandidate_tab_content">
                        <div class="tab-content" id="pills-tabContent">
                            @if ($currentTab == 'pills-profile')

                                @include('candidate.profile')

                            @elseif ($currentTab == 'pills-personal')

                                @include('candidate.personal')

                            @elseif ($currentTab == 'pills-educational')

                                @include('candidate.educational-detail')

                            @elseif ($currentTab == 'pills-professional')

                                @include('candidate.professional')

                            @elseif ($currentTab == 'pills-project')

                                @include('candidate.project')

                            @elseif ($currentTab == 'pills-training')

                                @include('candidate.training')

                            @elseif ($currentTab == 'pills-member')

                                @include('candidate.membership')

                            @elseif ($currentTab == 'pills-address')

                                @include('candidate.address')

                            @elseif ($currentTab == 'pills-keywords')

                                @include('candidate.keyword')

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./container -->
        @if ($currentTab == 'pills-educational')
            @include('candidate.create-education')
        @endif
        <!--  -->
        <!-- professional drawer -->
        @if ($currentTab == 'pills-professional')
            @include('candidate.create-profession')
        @endif
        <!--  -->
        <!-- project drawer -->
        @if ($currentTab == 'pills-project')
            @include('candidate.create-project')
        @endif
        <!--  -->
        <!-- training drawer -->
        @if ($currentTab == 'pills-training')
            @include('candidate.create-training')
        @endif
        <!--  -->
        <!-- membership drawer -->
        @if ($currentTab == 'pills-member')
            @include('candidate.create-membership')
        @endif
        <!--  -->
        <!-- address drawer -->
        @if ($currentTab == 'pills-address')
            @include('candidate.create-address')
        @endif
        <!--  -->
        @include('candidate.comment-view')
        @include('candidate.candidate-cv')
    </section>

</main>
@endsection
@push('scripts')
    <script>

        $(document).ready(function () {
            previousTab = $('.show.active').prop('id');
            $('#{{$currentTab}}-tab').tab('show');
            $('#{{$currentTab}}').addClass('active');
            $('#{{$currentTab}}').addClass('show');
        });

        $(".nav-link").on("click", function(){
            var target = $(this).data('target');
            console.log(target);
            let url =  "{{ route('candidate.show', ':id') }}";
            url = url.replace(':id', {{ $candidate->id}});
            window.location = url+"?tab="+target;
        });


        function printPage() {
            window.print();
        }


    </script>
@endpush