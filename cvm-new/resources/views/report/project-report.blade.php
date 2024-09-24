@extends('layouts.app')
@section('content')
<main class="report-wrapper">
    <section class="inner__wrapper">
        <div class="container-fluid">
            <div class="title">Candidates Project</div>
            <div class="row">
                <div class="col-3">
                    <div class="general_filter">
                        <div class="first-filter-header">
                            <h3 class="general-filters-cont">Filters
                                <div class="notification">
                                    <a href="{{route('report.candidate-project')}}">
                                    <img src="{{asset('/')}}images/icons/undo-arrow.png" width="20" alt="">
                                    </a>
                                </div>
                            </h3>
                        </div>
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <div class="filter-icons-flex">
                                            <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">
                                                Project Details
                                            </button>
                                            <img src="{{asset('images/icons/select-drop.png')}}" />
                                        </div>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="form_wrapper">
                                            <div class="input_grp">
                                                <label for="">Nationality</label>
                                                <select name="country_id" class="country_id">
                                                    <option value="" selected>Please select country</option>
                                                    @foreach ($country as $vs)
                                                    <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Designation</label>
                                                <select name="designation_id" class="designation_id">
                                                    <option value="">Select Designation</option>
                                                    @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}">{{ $designation->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Terrain</label>
                                                <select name="terrain_id" class="terrain_id">
                                                    <option value="">Select Terrain</option>
                                                    @foreach ($terrains as $terrain)
                                                    <option value="{{ $terrain->id }}">{{ $terrain->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Funding Agency</label>
                                                <select name="funding_agency_id" class="funding_agency_id">
                                                    <option value="">Select Funding Agency</option>
                                                    @foreach ($fundingAgency as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Sector</label>
                                                <select name="sector_id" class="sector_id">
                                                    <option value="">Select Sector</option>
                                                    @foreach ($sectors as $sector)
                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Phases</label>
                                                <select name="phase_id" class="phase_id">
                                                    <option value="">Select phases</option>
                                                    @foreach ($phases as $phase)
                                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input_grp">
                                                <label for="">Mode Of Contract</label>
                                                <select name="contract_mode_id" class="contract_mode_id">
                                                    <option value="">Select contract mode</option>
                                                    @foreach ($contracts as $contract)
                                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="filter-search-input">
                                <div class="form_wrapper">
                                    <div class="input_grp">
                                        <span>International Experience</span>
                                        <div class="radio-container">
                                            <div class="radio">
                                                <input id="radio-1" name="intExperience" class="intExperience"
                                                    type="radio" value="yes">
                                                <label for="radio-1" class="radio-label">Yes</label>
                                            </div>
                                            <div class="radio">
                                                <input id="radio-2" name="intExperience" class="intExperience"
                                                    type="radio" value="no">
                                                <label for="radio-2" class="radio-label">No</label>
                                            </div>
                                            <div class="radio">
                                                <input id="radio-3" name="intExperience" class="intExperience"
                                                    type="radio" value="both">
                                                <label for="radio-3" class="radio-label">Both</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="reports-table-cont">
                        <div class="table__wrapper">
                            <table class="table report-project display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Candidate name</th>
                                        <th scope="col">Project name</th>
                                        <th scope="col">Desigation</th>
                                        <th scope="col">Project from</th>
                                        <th scope="col">Project to</th>
                                        <th scope="col">Industry</th>
                                        <th scope="col">Sector</th>
                                        <th scope="col">Phase</th>
                                        <th scope="col">Employer name</th>
                                        <th scope="col">Project type</th>
                                        <th scope="col">Project length</th>
                                        <th scope="col">Project cost</th>
                                        <th scope="col">Funding agency</th>
                                        <th scope="col">Project cost</th>
                                        <th scope="col">Contract mode</th>
                                        <th scope="col">Terrain</th>
                                        {{-- <th scope="col" width="18%">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- ./table__wrapper -->
                    </div>
                </div>
            </div>
    </section>
</main>
@push('scripts')
<script type="text/javascript">
$(function() {
    var table = $('.report-project').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('report.candidate-project') }}",
            data: function(d) {
                d.country_id = $('.country_id').val(),
                    d.designation_id = $('.designation_id').val(),
                    d.funding_agency_id = $('.funding_agency_id').val(),
                    d.phase_id = $('.phase_id').val(),
                    d.sector_id = $('.sector_id').val(),
                    d.contract_mode_id = $('.contract_mode_id').val(),
                    d.terrain_id = $('.terrain_id').val(),
                    d.intExperience = $("input[name='intExperience']:checked").val(),
                    d.search = $('input[type="search"]').val()
            }
        },
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'candidate',
                name: 'candidate.id'
            },
            {
                data: 'name',
                name: 'name'
            },

            {
                data: 'designation',
                name: 'designation.name'
            },
            {
                data: 'from',
                name: 'From'
            },
            {
                data: 'to',
                name: 'To'
            },
            {
                data: 'industry',
                name: 'industry.id'
            },
            {
                data: 'sector',
                name: 'sector.id'
            },
            {
                data: 'phase',
                name: 'phase.id'
            },
            {
                data: 'employer_name',
                name: 'employer_name'
            },
            {
                data: 'project_type',
                name: 'project_type'
            },
            {
                data: 'project_length',
                name: 'project_length'
            },
            {
                data: 'project_cost',
                name: 'project_cost'
            },
            {
                data: 'funding_agency_id',
                name: 'funding_agency_id'
            },
            {
                data: 'contract_mode_id',
                name: 'contract_mode_id'
            },
            {
                data: 'terrain_id',
                name: 'terrain_id'
            },
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: false,
            //     searchable: false
            // },
        ]
    });
    $('.country_id').on('change', function() {
        table.draw();
    });

    $('.designation_id').on('change', function() {
        table.draw();
    });
    // $('.pavement_id').on('change', function() {
    //     table.draw();
    // });
    $('.funding_agency_id').on('change', function() {
        table.draw();
    });
    $('.phase_id').on('change', function() {
        table.draw();
    });
    $('.sector_id').on('change', function() {
        table.draw();
    });
    $('.contract_mode_id').on('change', function() {
        table.draw();
    });
    $('.terrain_id').on('change', function() {
        table.draw();
    });
    $('.intExperience').on('change', function() {
        table.draw();
    });
});

$(".country_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".designation_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".terrain_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".funding_agency_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".sector_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".phase_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
$(".contract_mode_id").each(function() {
    $(this).select2({
        theme: "bootstrap4",
        width: "style",
        placeholder: $(this).attr("placeholder"),
        allowClear: Boolean($(this).data("allow-clear")),
    });
});
</script>
@endpush
@endsection