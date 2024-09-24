@extends('layouts.app')
@section('content')

<main class="dashboard-wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="dashboard-container">
                <div class="title">Dashboard</div>
                <div class="alert alert-danger span-email d-none" role="alert">
                    <img src="{{ asset('images/icons/warning.png')}}" width="25">
                    <span> Please Set Your Company Email Credentail</span>
                </div>
            </div>
            <div class="row">
                @if (auth()->user()->hasRole('super-admin'))
                    <div class="col-sm-3">
                        <div class="dashboard-first-card">
                            <img src="{{ asset('images/candidate.png')}}" alt="" width="45">
                            <div class="dashboard-first-numbers">
                                <h3>Total Registered Companies</h3>
                                <span id="totalCompanyData">{{$totalCompanyData}}</span>

                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-sm-2">
                    <div class="dashboard-first-card">
                        <img src="{{ asset('images/recurit.png')}}" alt="" width="45">
                        <div class="dashboard-first-numbers">
                            <h3>Total Candidates</h3>
                            <span id="totalCandidateData">{{$totalCandidateData}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="dashboard-first-card">
                        <img src="{{ asset('images/recurit.png')}}" alt="" width="45">
                        <div class="dashboard-first-numbers">
                            <h3>Total Employees</h3>
                            <span id="totalEmployee">{{$totalEmployee}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="dashboard-first-card">
                        <img src="{{ asset('images/verified.png')}}" alt="" width="45">
                        <div class="dashboard-first-numbers">
                            <h3>Total Verified Candidates</h3>
                            <span id="totalVerifiedCandidate">{{$totalVerifiedCandidate}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="dashboard-first-card">
                        <img src="{{ asset('images/verified.png')}}" alt="" width="45">
                        <div class="dashboard-first-numbers">
                            <h3>Last 90 Days</h3>
                            <span id="last90DaysCount">{{$last90DaysCount}}</span>
                        </div>
                    </div>
                </div>
               {{--  <div class="col-sm-2">
                    <div class="dashboard-first-card">
                        <img src="{{ asset('images/job.png')}}" alt="" width="45">
                        <div class="dashboard-first-numbers">
                            @if (auth()->user()->hasRole('super-admin'))
                            <h3>Availabel Active Tickets</h3>
                            <span>0</span>
                            @else
                            <h3>Total Job Post</h3>
                            <span id="totalJobPost"></span>
                            @endif
                        </div>
                    </div>
                </div> --}}

                <div class="col-sm-8">
                    <div class="chart-bar-dashboard">
                        <div class="title">Candidates By Sector</div>
                        <div class="chart-container">
                            <canvas id="chart_0"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="chart-bar-dashboard">
                        <div class="title">Stream/ Subject</div>
                        <figure class="highcharts-figure">
                            <div id="container_pie"></div>
                        </figure>
                        <span id="noDataMessage"></span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="candidate-table-dashboard">
                        <div class="title">Candidates By Sector</div>
                        <div class="dashboard-added-list">
                            <ul class="responsive-table">
                                <li class="table-header">
                                    <div class="">Sector</div>
                                    <div class="">(%) of Candidate</div>
                                    <div class="">Candidates</div>
                                </li>
                                <div id="sectorCounts"></div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="candidate-table-dashboard">
                        <div class="title">Stream/ Subject</div>
                        <div class="dashboard-added-list">
                            <ul class="responsive-table">
                                <li class="table-header">
                                    <div class="">STREAM/ SUBJECT</div>
                                    <div class="">(%) of Candidate</div>
                                    <div class="">Candidates</div>
                                </li>
                                <div id="subjectCounts"></div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="candidate-table-dashboard">
                        <div class="title">Candidates By Experience</div>
                        <div class="dashboard-added-list">
                            <ul class="responsive-table">
                                <li class="table-header">
                                    <div class="">EXPERIENCE</div>
                                    <div class="">(%) of Candidate</div>
                                    <div class="">Candidates</div>
                                </li>
                                <div id="candidateExp"></div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="candidate-table-dashboard">
                        <div class="title">Candidates By Age Group</div>
                        <div class="dashboard-added-list">
                            <ul class="responsive-table">
                                <li class="table-header">
                                    <div class="">Age</div>
                                    <div class="">(%) of Candidate</div>
                                    <div class="">Candidates</div>
                                </li>
                                <div id="candidateAge"></div>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="candidate-table-dashboard">
                        <div class="title">Candidates By Education Level</div>
                        <div class="dashboard-added-list">
                            <ul class="responsive-table">
                                <li class="table-header">
                                    <div class="">QUALIFICATION</div>
                                    <div class="">(%) of Candidate</div>
                                    <div class="">Candidates</div>
                                </li>
                                <div id="eduLevelCounts"></div>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
@endsection
@push('scripts')
<script>
    $( document ).ready(function() {
        $.ajax({
                url: '{{ url('/home') }}',
                type: 'GET',
                success: function(response) {
                    var len = 0;
                    if(response.sectorCounts != null){
                        len = response.sectorCounts.length;
                    }
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var id = response.sectorCounts[i].id;
                            var name = response.sectorCounts[i].name;
                            var percentage = response.sectorCounts[i].percentage;
                            var count = response.sectorCounts[i].count;
                            var data ="<li class='table-row'><div class="+id+" data-label='Stream/Sector'>"+name+"</div><div class='candidate_percent' data-label='Percent'>"+ percentage +"%</div><div class='candidate_count' data-label='Total Candidate'>"+count+"</div></li>";
                            $("#sectorCounts").append(data);
                        }
                    }
                    else
                    {
                        var data = '<li><span class="no_recode">No Record Found</span></li>';
                        $("#sectorCounts").append(data);
                    }

                    var subjectLen = 0;
                    if(response.subjectCounts != null){
                        subjectLen = response.subjectCounts.length;
                    }
                    if(subjectLen > 0){
                        for(var i=0; i<subjectLen; i++){
                            var name = response.subjectCounts[i].name;
                            var percentage = response.subjectCounts[i].percentage;
                            var count = response.subjectCounts[i].count;
                            var data ="<li class='table-row'><div class='sector_id' data-label='Stream/Subject'>"+ name +"</div><div class='candidate_percent' data-label='Percent'>"+ percentage +"%</div><div class='candidate_count' data-label='Total Candidate'>"+ count +"</div></li>";
                            $("#subjectCounts").append(data);
                        }
                    }
                    else
                    {
                        var data = '<li><span class="no_recode">No Record Found</span></li>';
                        $("#subjectCounts").append(data);
                    }

                    if(response.candidateExp != null){
                        var data ="<li class='table-row'><div class='sector_id' data-label='Stream/Subject'>1-15Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.start.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.start.count+"</div><li class='table-row'><div class='sector_id' data-label='Stream/Subject'>16-30Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.middle.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.middle.count+"</div><li class='table-row'><div class='sector_id' data-label='Stream/Subject'>30+ Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.end.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.end.count+"</div>";
                        $("#candidateExp").append(data);
                    }
                    else
                    {
                        var data = '<li><span class="no_recode">No Record Found</span></li>';
                        $("#candidateExp").append(data);
                    }

                    if(response.candidateAge != null){
                        var data ="<li class='table-row'><div class='sector_id' data-label='Stream/Subject'>25-40Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.start.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.start.count+"</div><li class='table-row'><div class='sector_id' data-label='Stream/Subject'>41-60Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.middle.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.middle.count+"</div><li class='table-row'><div class='sector_id' data-label='Stream/Subject'>60+ Years</div><div class='candidate_amount' data-label='Percent'>"+response.candidateExp.end.percentage+"%</div><div class='candidate_status' data-label='Total Candidate'>"+response.candidateExp.end.count+"</div>";
                        $("#candidateAge").append(data);
                    }
                    else
                    {
                        var data = '<li><span class="no_recode">No Record Found</span></li>';
                        $("#candidateAge").append(data);
                    }

                    var educationLen = 0;
                    if(response.eduLevelCounts != null){
                        educationLen = response.eduLevelCounts.length;
                    }
                    if(educationLen > 0){
                        for(var i=0; i<educationLen; i++){
                            var name = response.eduLevelCounts[i].name;
                            var percentage = response.eduLevelCounts[i].percentage;
                            var count = response.eduLevelCounts[i].count;
                            var data ="<li class='table-row'><div class='sector_id' data-label='Stream/Subject'>"+ name +"</div><div class='candidate_percent' data-label='Percent'>"+ percentage +"%</div><div class='candidate_count' data-label='Total Candidate'>"+ count +"</div></li>";
                            $("#eduLevelCounts").append(data);
                        }
                    }
                    else
                    {
                        var data = '<li><span class="no_recode">No Record Found</span></li>';
                        $("#eduLevelCounts").append(data);
                    }

                    if(response.emailSetting != null)
                    {
                        $('.span-email').removeClass('d-none');
                    }
                }
            });
    });


    async function fetchDataAndPopulateChart() {
        try {
            const response = await fetch('/candidate-by-sector');
            const chartData = await response.json();

            if (chartData.labels.length === 0) {
                chartData.labels = ["No Record Found"];
            }

            var data = {
                labels: chartData.labels,
                datasets: [{
                    label: "Dataset #1",
                    backgroundColor: "#8bc7f2",
                    borderColor: "#2e66f6",
                    borderWidth: 2,
                    hoverBackgroundColor: "#09AC58",
                    hoverBorderColor: "#8bc7f2",
                    data: chartData.data,
                }]
            };

            var option = {
                scales: {
                    yAxes: [{
                        stacked: true,
                        gridLines: {
                            display: true,
                            color: "#8bc7f2"
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            };

            Chart.Bar('chart_0', {
                options: option,
                data: data
            });
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }
    fetchDataAndPopulateChart();


// donut chart
fetch('/getSubjects')
    .then((response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then((data) => {
        const subjects = data;

        var chartData = [];

        for (var i = 0; i < subjects.name.length; i++) {
            var subjectName = subjects.name[i];
            var subjectValue = subjects.data[i];

            var dataPoint = {
                name: subjectName,
                y: subjectValue,
                z: subjectValue,
            };

            chartData.push(dataPoint);
        }

        var dataPoint;
        if (subjects.data.length === 0) {
            dataPoint = {
                name: 'No Record Found',
                y: 0,
                z: 0,
            };
            chartData.push(dataPoint);
        }
        Highcharts.chart('container_pie', {
            chart: {
                type: 'variablepie',
            },
            tooltip: {
                headerFormat: '',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                    'Candidate By Subject: <b>{point.y}</b><br/>' +
                    'Candidate density (candidate according to subject): <b>{point.z}</b><br/>',
            },
            series: [{
                minPointSize: 10,
                innerSize: '20%',
                zMin: 0,
                name: 'countries',
                borderRadius: 5,
                data: chartData,
                colors: [
                    '#4caefe',
                    '#3dc3e8',
                    '#2dd9db',
                    '#1feeaf',
                    '#0ff3a0',
                    '#00e887',
                    '#23e274',
                ],
            }, ],
        });
    })
    .catch((error) => {
        console.error('Error fetching subjects:', error);
    });
</script>
@endpush