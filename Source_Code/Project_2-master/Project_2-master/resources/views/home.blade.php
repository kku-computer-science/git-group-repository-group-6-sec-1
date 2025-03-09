@extends('layouts.layout')
<style>
    .count {
        background-color: #f5f5f5;
        padding: 20px 0;
        border-radius: 5px;
    }

    .count-title {
        font-size: 40px;
        font-weight: normal;
        margin-top: 10px;
        margin-bottom: 0;
        text-align: center;
    }

    .count-text {
        font-size: 15px;
        font-weight: normal;
        margin-top: 10px;
        margin-bottom: 0;
        text-align: center;
    }

    .fa-2x {
        margin: 0 auto;
        float: none;
        display: table;
        color: #4ad1e5;
    }
</style>
@section('content')
<div class="container home">
    <div class="container d-sm-flex justify-content-center mt-5">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('img/Banner1_' . (app()->getLocale() == 'th' ? 'th' : (app()->getLocale() == 'en' ? 'en' : 'zh')) . '.png') }}" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/Banner2_' . (app()->getLocale() == 'th' ? 'th' : (app()->getLocale() == 'en' ? 'en' : 'zh')) . '.png') }}" class="d-block w-100" alt="Banner 2">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container card-cart d-sm-flex justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="chart" style="height: 350px;">
                        <canvas id="barChart1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="container mt-3">
        <div class="row text-center">
            <div class="col">
                <div class="count" id='all'></div>
            </div>
            <div class="col">
                <div class="count" id='scopus'></div>
            </div>
            <div class="col">
                <div class="count" id='wos'></div>
            </div>
            <div class="col">
                <div class="count" id='tci'></div>
            </div>
        </div>
    </div>

    <div class="modal" id="myModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('reference.reference_apa') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="name"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('reference.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mixpaper pb-10 mt-3">
        <h3>{{ trans('message.publications') }}</h3>
        @foreach($papers as $n => $pe)
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$n}}" aria-expanded="true" aria-controls="collapseOne">
                        @if (!$loop->last)
                        {{$n}}
                        @else
                        Before {{$n}}
                        @endif
                    </button>
                </h2>
                <div id="collapse{{$n}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        @foreach($pe as $n => $p)
                        <div class="row mt-2 mb-3 border-bottom">
                            <div id="number" class="col-sm-1">
                                <h6>[{{$n+1}}]</h6>
                            </div>
                            <div id="paper2" class="col-sm-11">
                                <p class="hidden">
                                    <b>{{$p['paper_name']}}</b> (
                                    <link>{{$p['author']}}</link>), {{$p['paper_sourcetitle']}}, {{$p['paper_volume']}},
                                    {{$p['paper_yearpub']}}.
                                    <a href="{{$p['paper_url']}}" target="_blank">[url]</a> 
                                    <a href="https://doi.org/{{$p['paper_doi']}}" target="_blank">[doi]</a>
                                    <button style="padding: 0;" class="btn btn-link open_modal" value="{{$p['id']}}">[{{ trans('reference.label') }}]</button>
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    $(document).ready(function() {
        $(".moreBox").slice(0, 1).show();
        if ($(".blogBox:hidden").length != 0) {
            $("#loadMore").show();
        }
        $("#loadMore").on('click', function(e) {
            e.preventDefault();
            $(".moreBox:hidden").slice(0, 1).slideDown();
            if ($(".moreBox:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
            }
        });
    });
</script>
<script>
    var year = <?php echo $year; ?>;
    var paper_tci = <?php echo $paper_tci; ?>;
    var paper_scopus = <?php echo $paper_scopus; ?>;
    var paper_wos = <?php echo $paper_wos; ?>;
    var areaChartData = {
        labels: year,
        datasets: [{
                label: 'SCOPUS',
                backgroundColor: '#3994D6',
                borderColor: 'rgba(210, 214, 222, 1)',
                pointRadius: false,
                pointColor: '#3994D6',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: '#3994D6',
                data: paper_scopus
            },
            {
                label: 'TCI',
                backgroundColor: '#83E4B5',
                borderColor: 'rgba(255, 255, 255, 0.5)',
                pointRadius: false,
                pointColor: '#83E4B5',
                pointStrokeColor: '#3b8bba',
                pointHighlightFill: '#fff',
                pointHighlightStroke: '#83E4B5',
                data: paper_tci
            },
            {
                label: 'WOS',
                backgroundColor: '#FCC29A',
                borderColor: 'rgba(0, 0, 255, 1)',
                pointRadius: false,
                pointColor: '#FCC29A',
                pointStrokeColor: '#c1c7d1',
                pointHighlightFill: '#fff',
                pointHighlightStroke: '#FCC29A',
                data: paper_wos
            },
        ]
    }

    var barChartCanvas = $('#barChart1').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false,
        scales: {
            yAxes: [{
                formatter: function() {
                    return Math.abs(this.value);
                },
                scaleLabel: {
                    display: true,
                    labelString: '{{ trans('reference.number') }}',
                },
                ticks: {
                    reverse: false,
                    stepSize: 10
                },
            }],
            xAxes: [{
                scaleLabel: {
                    display: true,
                    labelString: '{{ trans('reference.year') }}'
                }
            }]
        },
        title: {
            display: true,
            text: '{{ trans('reference.report_title') }}',
            fontSize: 20
        }
    }

    new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
    })
</script>
<script>
    var paper_tci = <?php echo $paper_tci_numall; ?>;
    var paper_scopus = <?php echo $paper_scopus_numall; ?>;
    var paper_wos = <?php echo $paper_wos_numall; ?>;
    let sumtci = paper_tci;
    let sumsco = paper_scopus;
    let sumwos = paper_wos;
    (function($) {
        let sum = paper_wos + paper_tci + paper_scopus;
        document.getElementById("all").innerHTML += `
                <i class="count-icon fa fa-book fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="${sum}" data-speed="1500"></h2>
                <p class="count-text ">{{ trans('reference.summary') }}</p>`
        document.getElementById("scopus").innerHTML += `
                <i class="count-icon fa fa-book fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="${sumsco}" data-speed="1500"></h2>
                <p class="count-text ">{{ trans('reference.scopus') }}</p>`
        document.getElementById("wos").innerHTML += `
                <i class="count-icon fa fa-book fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="${sumwos}" data-speed="1500"></h2>
                <p class="count-text ">{{ trans('reference.wos') }}</p>`
        document.getElementById("tci").innerHTML += `
                <i class="count-icon fa fa-book fa-2x"></i>
                <h2 class="timer count-title count-number" data-to="${sumtci}" data-speed="1500"></h2>
                <p class="count-text ">{{ trans('reference.tci') }}</p>`

        $.fn.countTo = function(options) {
            options = options || {};
            return $(this).each(function() {
                var settings = $.extend({}, $.fn.countTo.defaults, {
                    from: $(this).data('from'),
                    to: $(this).data('to'),
                    speed: $(this).data('speed'),
                    refreshInterval: $(this).data('refresh-interval'),
                    decimals: $(this).data('decimals')
                }, options);

                var loops = Math.ceil(settings.speed / settings.refreshInterval),
                    increment = (settings.to - settings.from) / loops;

                var self = this,
                    $self = $(this),
                    loopCount = 0,
                    value = settings.from,
                    data = $self.data('countTo') || {};

                $self.data('countTo', data);

                if (data.interval) {
                    clearInterval(data.interval);
                }
                data.interval = setInterval(updateTimer, settings.refreshInterval);

                render(value);

                function updateTimer() {
                    value += increment;
                    loopCount++;
                    render(value);

                    if (typeof(settings.onUpdate) == 'function') {
                        settings.onUpdate.call(self, value);
                    }

                    if (loopCount >= loops) {
                        $self.removeData('countTo');
                        clearInterval(data.interval);
                        value = settings.to;

                        if (typeof(settings.onComplete) == 'function') {
                            settings.onComplete.call(self, value);
                        }
                    }
                }

                function render(value) {
                    var formattedValue = settings.formatter.call(self, value, settings);
                    $self.html(formattedValue);
                }
            });
        };

        $.fn.countTo.defaults = {
            from: 0,
            to: 0,
            speed: 1000,
            refreshInterval: 100,
            decimals: 0,
            formatter: formatter,
            onUpdate: null,
            onComplete: null
        };

        function formatter(value, settings) {
            return value.toFixed(settings.decimals);
        }
    }(jQuery));

    jQuery(function($) {
        $('.count-number').data('countToOptions', {
            formatter: function(value, options) {
                return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, ',');
            }
        });

        $('.timer').each(count);

        function count(options) {
            var $this = $(this);
            options = $.extend({}, options || {}, $this.data('countToOptions') || {});
            $this.countTo(options);
        }
    });
</script>
<script>
    $(document).on('click', '.open_modal', function() {
        var tour_id = $(this).val();
        $.get('/bib/' + tour_id, function(data) {
            console.log(data);
            $(".bibtex-biblio").remove();
            document.getElementById("name").innerHTML += `${data}`;
            $( ".bibtex-biblio" ).remove();
            document.getElementById("name").innerHTML += `${data}`
            $('#myModal').modal('show');
        });
    });
</script>
@endsection