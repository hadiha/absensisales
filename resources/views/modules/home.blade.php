@extends('layouts.form')

@section('css')
@append

@section('js')
    <script src="{{ asset('plugins/highchart/highcharts.js') }}"></script>
    <script src="{{ asset('plugins/highchart/js/modules/series-label.js') }}"></script>
    <script src="{{ asset('plugins/highchart/js/modules/exporting.js') }}"></script>
    <script src="{{ asset('plugins/highchart/js/modules/export-data.js') }}"></script>
    <script src="{{ asset('plugins/highchart/js/modules/accessibility.js') }}"></script>
@append

@section('styles')
    <style type="text/css">
        
    </style>
@append

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#filter').calendar({
                type: 'year',
            });

            showDashboard($('[name="year"]').val());
        });

        function statistikKehadiran(data = []){
            Highcharts.chart('container', {

            title: {
                text: 'Grafik Kehadiran & Absensi Perbulan'
            },

            subtitle: {
                text: 'Periode ' + data.periode
            },

            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Persentase (%)'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: false
                    },
                    enableMouseTracking: true
                }
            },
            credits: {
                enabled: false
            },

            series: [{
                name: 'Hadir',
                data: data.hadir
            }, {
                name: 'Sakit',
                data: data.sakit
            }, {
                name: 'Izin',
                data: data.izin
            }, {
                name: 'Cuti',
                data: data.cuti
            }, {
                name: 'Tanpa Keterangan',
                data: data.tk
            }],

            });
        }


    function showDashboard(year){
        var url = "{{ url('home/get-data') }}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                '_method' : 'POST',
                '_token' : '{{ csrf_token() }}',
                'year' : year,
            }
        })
        .done(function(response) {
            statistikKehadiran(response.chart);
        })
        .fail(function(response) {
            
        })
    }

    </script>
@append

@section('form')
	{{-- <h1 class="ui center aligned header" style="line-height: 500px">
		U N D E R &nbsp; &nbsp; C O N S T R U C T I O N
    </h1> --}}
    <div class="ui grid">
        <div class="two column computer only row">
          <div class="twelve wide column">
            <div class="ui form">
                <div class="inline fields">
                  <div class="two wide field" style="padding-left: 20px">
                    <label>Filter</label>
                  </div>
                  <div class="four wide field">
                    <div class="ui month" id="filter" style="width: 100%">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" name="year"  placeholder="Tahun" value="{{ Carbon::now()->startOfMonth() }}">
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <figure class="highcharts-figure">
                <div id="container"></div>
                {{-- <p class="highcharts-description">
                    Basic line chart showing trends in a dataset. This chart includes the
                    <code>series-label</code> module, which adds a label to each line for
                    enhanced readability.
                </p> --}}
            </figure>
          </div>
          <div class="four wide column">
            <div class="ui card">
                <div class="content">
                  <div class="header">5 Kehadiran Terbaik</div>
                </div>
                <div class="content">
                    @foreach ($top as $best)
                        <div class="card">
                            <div class="content">
                            <img class="right floated mini ui image" src="{{asset('img/avatar04.png')}}">
                            <div class="header">
                                <b>{{$best->name}} </b>
                            </div>
                            {{-- <div class="meta">
                                Friends of Veronika
                            </div> --}}
                            <div class="description">
                                {{$best->absensi_count}}x Hadir
                            </div>
                            </div>
                        </div>
                        <hr style="margin-top: 0px">
                    @endforeach
                </div>
            </div>

            <div class="ui card">
                <div class="content">
                  <div class="header">5 Kehadiran Terburuk</div>
                </div>
                <div class="content">
                    @foreach ($worst as $best)
                        <div class="card">
                            <div class="content">
                            <img class="right floated mini ui image" src="{{asset('img/avatar04.png')}}">
                            <div class="header">
                                <b>{{$best->name}} </b>
                            </div>
                            {{-- <div class="meta">
                                Friends of Veronika
                            </div> --}}
                            <div class="description">
                                {{$best->absensi_count}}x Hadir
                            </div>
                            </div>
                        </div>
                        <hr style="margin-top: 0px">
                    @endforeach
                </div>
            </div>
          </div>
        </div>
      </div>
@endsection
