@extends('layouts.app')
@section('content')
    <main class="company_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div id="title">Report</div><br><br>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Nationality</label>
                            <select name="country_id" class="country_id">
                                <option value="" selected>Please select country</option>
                                @foreach ($country as $vs)
                                    <option value="{{ $vs->id }}">{{ $vs->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Languages</label>
                            <select name="language_id" class="language">
                                <option value="">Select Languages</option>
                                @foreach ($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Gender</label>
                            <select name="gender" class="gender">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Age</label>
                            <div class="input-group">
                                <input type="text" name="minAge" class="form-control minAge" value=""
                                    placeholder="Min Age">
                                <input type="text" name="maxAge" class="form-control maxAge" value=""
                                    placeholder="Max Age">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Qualification Level</label>
                            <select name="educational_level_id" class="educational_level_id">
                                <option value="">Select Qualification Level</option>
                                @foreach ($educationalLevels as $educationalLevel)
                                    <option value="{{ $educationalLevel->id }}">{{ $educationalLevel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">COURSE/ PROGRAM</label>
                            <select name="city_id" class="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Experience</label>
                            <div class="input-group">
                                <input type="text" name="minExp" value="" class="form-control minExp"
                                    placeholder="Min Experience">
                                <input type="text" name="maxExp" value="" class="form-control maxExp"
                                    placeholder="Max Experience">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Designation</label>
                            <select name="designation_id" class="designation_id">
                                <option value="">Select Designation</option>
                                @foreach ($designations as $designation)
                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">PAVEMENT</label>
                            <select name="city_id" class="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">FUNDING AGENCY</label>
                            <select name="city_id" class="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Sector</label>
                            <select name="sector_id" class="sector_id">
                                <option value="">Select Sector</option>
                                @foreach ($sectors as $sector)
                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Phases</label>
                            <select name="phases_id" class="phases_id">
                                <option value="">Select phases</option>
                                @foreach ($phases as $phase)
                                    <option value="{{ $phase->id }}">{{ $phase->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">KEYWORDS</label>
                            <select name="city_id" class="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">TRAINING/ CERTIFICATION</label>
                            <select name="certificate_id" class="certificate_id">
                                <option value="">Select Certificate</option>
                                @foreach ($certificates as $certificate)
                                    <option value="{{ $certificate->id }}">{{ $certificate->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">Membership</label>
                            <select name="membership_id" class="membership_id">
                                <option value="">Select Membership</option>
                                @foreach ($memberships as $membership)
                                    <option value="{{ $membership->id }}">{{ $membership->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">MODE OF CONTRACT</label>
                            <select name="city_id" class="city">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="input_grp">
                            <label for="">MODE OF CONTRACT</label>
                            <div class="row" style="padding:7px 0px;">
                                <div class="col">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="intlexp1" name="intlexp" class="custom-control-input"
                                            value="I">
                                        <label class="custom-control-label" for="intlexp1">Yes</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="intlexp2" name="intlexp" class="custom-control-input"
                                            value="N">
                                        <label class="custom-control-label" for="intlexp2">No</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="intlexp3" checked="checked" name="intlexp"
                                            class="custom-control-input" value="B">
                                        <label class="custom-control-label" for="intlexp3">Both</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ./row -->
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table__wrapper">
                            <form name="frm-example" id="frm-example">
                                <table class="table report-table display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Gender</th>
                                            <th scope="col">Language</th>
                                            <th scope="col">Desigation</th>
                                            <th scope="col">Qualification</th>
                                            <th scope="col" width="18%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <!-- ./table__wrapper -->
                    </div>
                </div>
                <!-- ./row -->
            </div>
            <!-- ./container -->
        </section>
    </main>
    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var table = $('.report-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('report.index') }}",
                        data: function(d) {
                            d.country_id = $('.country_id').val(),
                                d.gender = $('.gender').val(),
                                d.language = $('.language').val(),
                                d.minAge = $('.minAge').val(),
                                d.maxAge = $('.maxAge').val(),
                                d.minExp = $('.minExp').val(),
                                d.maxExp = $('.maxExp').val(),
                                d.designation_id = $('.designation_id').val(),
                                d.educational_level_id = $('.educational_level_id').val(),
                                d.certificate_id = $('.certificate_id').val(),
                                d.membership_id = $('.membership_id').val(),
                                d.search = $('input[type="search"]').val()
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'first_name',
                            name: 'name'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'language_known',
                            name: 'language'
                        },
                        //   {data: 'qualification', name: 'qualification'},
                        //   {data: 'experience', name: 'experience'},
                        //   {data: 'created_at', name: 'created_at'},
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
                $('.country_id').on('change', function() {
                    table.draw();
                });
                $('.minAge').on('change', function() {
                    table.draw();
                });
                $('.maxAge').on('change', function() {
                    table.draw();
                });
                $('.language').on('change', function() {
                    table.draw();
                });
                $('.designation').on('change', function() {
                    table.draw();
                });
                $('.gender').on('change', function() {
                    table.draw();
                });
                $('.educational_level_id').on('change', function() {
                    table.draw();
                });
                $('.designation_id').on('change', function() {
                    table.draw();
                });
                $('.certificate_id').on('change', function() {
                    table.draw();
                });
                $('.membership_id').on('change', function() {
                    table.draw();
                });
                $('.minExp').on('change', function() {
                    table.draw();
                });
                $('.maxExp').on('change', function() {
                    table.draw();
                });
            });
        </script>
    @endpush
@endsection
