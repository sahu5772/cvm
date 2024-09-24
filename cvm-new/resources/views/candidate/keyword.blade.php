<div class="tab-pane fade" id="pills-keywords" role="tabpanel" aria-labelledby="pills-keywords-tab">
    <main class="candidate_Keywords_wrapper">
        <section class="inner__wrapper">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="title">Keywords</div>
                </div>
                <!-- ./heading -->

                <div class="row">
                    <div class="col-12">
                        <div class="addresss_access_wrap">
                            <div class="page_permission">
                                <div class="title">Industries</div>
                                <div class="rp_list">
                                    @foreach ($industries as $industry)
                                        <div class="rp_item">
                                            <div class="switch_button">
                                                <label class="switch">
                                                    <input type="radio" name="industry"
                                                        class="industry-data industry_{{ $industry->id }}"
                                                        value="{{ $industry->id }}"
                                                        @if ($keywords && $industry->id == $keywords->industry_id) checked @endif />
                                                    <span class="slider"></span>
                                                </label>
                                                <div>{{ ucfirst($industry->name) }}</div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="page_permission sector-record">
                                <div class="title">Sectors</div>
                                <div class="rp_list sector-data-value">
                                    @foreach ($sectors as $sector)
                                        <div class="rp_item">
                                            <div class="switch_button">
                                                <label class="switch">
                                                    <input type="radio" name="sector_id" class="sector-data-data"
                                                        value="{{ $sector->id }}"
                                                        @if ($keywords && $sector->id == $keywords->sector_id) checked @endif
                                                        onclick="sector({{ $sector->id }})" />
                                                    <span class="slider"></span>
                                                </label>
                                                <div>{{ ucfirst($sector->name) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="page_permission phase-record">
                                <div class="title">Phase</div>
                                <div class="rp_list phase-data">
                                    @foreach ($phases as $phase)
                                        <div class="rp_item">
                                            <div class="switch_button">
                                                <label class="switch">
                                                    <input type="radio" name="phase_id" class="phase-data-id"
                                                        value="{{ $phase->id }}"
                                                        @if ($keywords && $phase->id == $keywords->phase_id) checked @endif
                                                        onclick="phaseData({{ $phase->id }})" />
                                                    <span class="slider"></span>
                                                </label>
                                                <div>{{ ucfirst($phase->name) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="page_permission keyword-record">
                                <div class="title">Keyword</div>
                                <div class="keyword-phases">
                                    <input type="hidden" value="{{ request()->segment(2) }}" name="candidate_id"
                                        class="candidate_id">
                                    <input type="hidden" value="" name="industry_id" class="industry_id">
                                    <input type="hidden" value="" name="sector_id" class="sector_id">
                                    <input type="hidden" value="" name="phase_id" class="phase_id">
                                    <div class="rp_list keyword-rp-list">
                                        @foreach ($keywordData as $keyword)
                                            <div class="rp_item">
                                                <div class="switch_button">
                                                    <label class="switch">
                                                        @php
                                                        $ddata = App\Models\KeywordRecord::orWhere('keyword_id',$keyword->id)->first();
                                                        @endphp
                                                        <input type="checkbox" name="keyword[]"
                                                            value="{{ $keyword->id }}"
                                                            @if ($ddata && $keyword->id == $ddata->keyword_id) checked @endif onclick="keyword({{$keyword->id}})"/>
                                                        <span class="slider"></span>
                                                    </label>
                                                    <div>{{ ucfirst($keyword->keyword) }}</div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
@push('scripts')
    <script>
        var datass = "{{ $keywords }}";
        if (!datass) {
            $('.sector-record').css({
                'display': 'none'
            });
            $('.keyword-record').css({
                'display': 'none'
            });
            $('.phase-record').css({
                'display': 'none'
            });
        }

        $(".industry-data").change(function() {

            var industry_id = this.value;
            var candidate_id = $('.candidate_id').val();
            $('.industry_id').val(industry_id);
            $.ajax({
                url: "{{ route('candidate-sector.index') }}",
                type: "get",
                data: {
                    candidate_id: candidate_id,
                    industry_id: industry_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    $('.sector-record').css({
                        'display': 'block'
                    });
                    // $('.phase-record').css({'display':'none'});
                    // $('.keyword-record').css({'display':'none'});
                    $('.sector-data-value').html(response.sectors);
                }
            });
        });

        function sector(id) {
            $('.sector_id').val(id);
            var candidate_id = $('.candidate_id').val();
            $.ajax({
                url: "{{ route('candidate-phase.phase') }}",
                type: "get",
                data: {
                    candidate_id: candidate_id,
                    sector_id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    $('.phase-record').css({
                        'display': 'block'
                    });
                    $('.phase-data').html(response.phases);
                }
            });
        }

        function phaseData(id) {
            $('.phase_id').val(id);
            var candidate_id = $('.candidate_id').val();
            $.ajax({
                url: "{{ route('candidate-keyword.keyword') }}",
                type: "get",
                data: {
                    candidate_id: candidate_id,
                    phase_id: id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    $('.keyword-record').css({
                        'display': 'block'
                    });
                    $('.keyword-rp-list').html(response.keywords);
                }
            });
        }

        function keyword(id) {
            var candidate_id = $('.candidate_id').val();
            var industry_id = $('.industry_id').val();
            var sector_id = $('.sector_id').val();
            var phase_id = $('.phase_id').val();
            var val = [];
            $(':checkbox:checked').each(function(i) {
                val[i] = $(this).val();
            });

            $.ajax({
                url: "{{ route('keyword.data') }}",
                type: "get",
                data: {
                    phase_id: phase_id,
                    sector_id: sector_id,
                    industry_id: industry_id,
                    candidate_id: candidate_id,
                    keyword_id: val,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                $('#res_message').fadeIn().html(
                '<div class="toast active"><div class="toast-content"><i class="fa fa-solid fa-check check"></i><div class="message"><span class="text text-2">'
                +response.message+'</span></div></div><i class="fa fa-times close"></i><div class="progress active"></div></div>');
                setTimeout(function(){
                $('#res_message').fadeIn().fadeOut();
                 }, 4000);
                }
            });
        }
    </script>
@endpush
