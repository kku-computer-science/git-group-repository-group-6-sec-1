@extends('layouts.layout')
@section('content')
@php
    // รับค่า locale ปัจจุบัน เช่น 'th', 'en', 'zh'
    $locale = app()->getLocale();
    // กำหนด path ของไฟล์ภาษาสำหรับ view นี้
    $langFile = resource_path("lang/{$locale}/research_project_view.php");
    // โหลดข้อความแปลจากไฟล์ หากไม่มีให้เป็นอาเรย์ว่าง
    $viewTexts = file_exists($langFile) ? include($langFile) : [];
@endphp

<div class="container refund">
    <p class="title-text">
        {{ $viewTexts['academic_service_research_project'] }}
    </p>

    <div class="table-refund table-responsive">
        <table id="example1" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="font-weight: bold;">{{ $viewTexts['no'] }}</th>
                    <th class="col-md-1" style="font-weight: bold;">{{ $viewTexts['year'] }}</th>
                    <th class="col-md-4" style="font-weight: bold;">{{ $viewTexts['project_name'] }}</th>
                    <th class="col-md-4" style="font-weight: bold;">{{ $viewTexts['details'] }}</th>
                    <th class="col-md-2" style="font-weight: bold;">{{ $viewTexts['project_leader'] }}</th>
                    <th class="col-md-1" style="font-weight: bold;">{{ $viewTexts['status'] }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resp as $i => $re)
                <tr>
                    <td style="vertical-align: top;text-align: left;">{{$i+1}}</td>
                    <td style="vertical-align: top;text-align: left;">
                        {{ $locale == 'th' ? ($re->project_year + 543) : $re->project_year }}
                    </td>
                    <td style="vertical-align: top;text-align: left;">
                        {{$re->project_name}}
                    </td>
                    <td>
                        <div style="padding-bottom: 10px">
                            @if ($re->project_start != null)
                                <span style="font-weight: bold;">{{ $viewTexts['project_duration'] }}</span>
                                <span style="padding-left: 10px;">
                                    @if($locale == 'th')
                                        {{ \Carbon\Carbon::parse($re->project_start)->thaidate('j F Y') }} ถึง
                                        {{ \Carbon\Carbon::parse($re->project_end)->thaidate('j F Y') }}
                                    @elseif($locale == 'en')
                                        {{ \Carbon\Carbon::parse($re->project_start)->format('j F Y') }} to
                                        {{ \Carbon\Carbon::parse($re->project_end)->format('j F Y') }}
                                    @elseif($locale == 'zh')
                                        {{ \Carbon\Carbon::parse($re->project_start)->locale('zh')->isoFormat('LL') }} 至
                                        {{ \Carbon\Carbon::parse($re->project_end)->locale('zh')->isoFormat('LL') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($re->project_start)->format('j F Y') }} to
                                        {{ \Carbon\Carbon::parse($re->project_end)->format('j F Y') }}
                                    @endif
                                </span>
                            @else
                                <span style="font-weight: bold;">{{ $viewTexts['project_duration'] }}</span>
                                <span></span>
                            @endif
                        </div>

                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ $viewTexts['research_fund_type'] }}</span>
                            <span style="padding-left: 10px;">
                                @if(is_null($re->fund))
                                    -
                                @else
                                    @if($re->fund->fund_type == 'ทุนภายนอก')
                                        @if($locale == 'en')
                                            External Funding
                                        @elseif($locale == 'zh')
                                            外部资金
                                        @else
                                            {{ $re->fund->fund_type }}
                                        @endif
                                    @elseif($re->fund->fund_type == 'ทุนภายใน')
                                        @if($locale == 'en')
                                            Internal Funding
                                        @elseif($locale == 'zh')
                                            内部资金
                                        @else
                                            {{ $re->fund->fund_type }}
                                        @endif
                                    @else
                                        {{ $re->fund->fund_type }}
                                    @endif
                                @endif
                            </span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ $viewTexts['funding_agency'] }}</span>
                            <span style="padding-left: 10px;">
                                @if(is_null($re->fund))
                                    -
                                @else
                                    @php
                                        $resource = $re->fund->support_resource;
                                        $translated = __('funds.support_resources.' . $resource);
                                    @endphp
                                    {{ $translated === 'funds.support_resources.' . $resource ? $resource : $translated }}
                                @endif
                            </span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ $viewTexts['responsible_agency'] }}</span>
                            <span style="padding-left: 10px;">
                                {{-- ใช้ mapping จากไฟล์ภาษา หากมีการแม็ปแล้วจะได้ภาษาอังกฤษ --}}
                                {{ isset($viewTexts['departments'][$re->responsible_department]) ? $viewTexts['departments'][$re->responsible_department] : $re->responsible_department }}
                            </span>
                        </div>
                        <div style="padding-bottom: 10px;">
                            <span style="font-weight: bold;">{{ $viewTexts['allocated_budget'] }}</span>
                            <span style="padding-left: 10px;">{{ number_format($re->budget) }} {{ $viewTexts['baht'] }}</span>
                        </div>
                    </td>
                    <td style="vertical-align: top;text-align: left;">
                        <div style="padding-bottom: 10px;">
                            <span>
                            @foreach($re->user as $user)
                                @if($locale == 'th')
                                    {{ $user->position_th }} {{ $user->fname_th }} {{ $user->lname_th }}<br>
                                @elseif($locale == 'en' || $locale == 'zh')
                                    {{ $user->position_en }} {{ $user->fname_en }} {{ $user->lname_en }}<br>
                                @else
                                    {{ $user->position_en }} {{ $user->fname_th }} {{ $user->lname_th }}<br>
                                @endif
                            @endforeach
                            </span>
                        </div>
                    </td>
                    @if($re->status == 1)
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge badge-success">{{ $viewTexts['requested'] }}</label></h6>
                    </td>
                    @elseif($re->status == 2)
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge bg-warning text-dark">{{ $viewTexts['in_progress'] }}</label></h6>
                    </td>
                    @else
                    <td style="vertical-align: top;text-align: left;">
                        <h6><label class="badge bg-dark">{{ $viewTexts['closed'] }}</label></h6>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- รวมสคริปต์ทั้งหมด -->
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<!-- <script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
        });
    });
</script> -->
<script>
    $(document).ready(function() {
        var table1 = $('#example1').DataTable({
            responsive: true,
            language: {
                lengthMenu: "@lang('datatables.lengthMenu')",
                search: "@lang('datatables.search')",
                info: "@lang('datatables.info')",
                infoEmpty: "@lang('datatables.infoEmpty')",
                zeroRecords: "@lang('datatables.zeroRecords')",
                paginate: {
                    first: "@lang('datatables.first')",
                    last: "@lang('datatables.last')",
                    next: "@lang('datatables.next')",
                    previous: "@lang('datatables.previous')"
                }
            }
        });
    });
</script>
@stop
