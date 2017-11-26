@extends('layouts.index')
@section('html_class','banader banader_homepage')
@section('specific_plugin_style')
    <link rel="stylesheet" type="text/css" href="{{url('layouts/banader/css/banader_style.css')}}"/>
@stop
@section('content')
    @include('index.helper.banader.index_content')
@stop

@section('inline_scripts')
    <script>
        $(document).ready(function () {
            var chart = Highcharts.chart('chart_statistics', {
                chart: {
                    height:370,
                    type: 'column',
                    style: {
                        fontFamily: 'IranSharp'
                    }
                },
                title: {
                    text: 'تعداد موضوعات'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    rtl: true,
                    title: {
                        text: 'تعداد'
                    },
                    opposite: true,
                },
                credits: {
                    enabled: false,

                },
                legend: {
                    enabled: false,
                    rtl: true
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:f}'
                        }
                    }
                },
                {{--
                    tooltip: {
                        useHTML: true,
                        formatter: function () {
                            return '<table><tr><td>' + this.point.name + ' </td><td>' + this.series.name + '</td></tr><tr><td style="float:right">' + Highcharts.numberFormat(Math.abs(this.point.y), 0) + '</td><td>تعداد</td></tr></table>';
                        }
                    },
                --}}
                series: [{
                    name: 'تعداد',
                    colorByPoint: true,
                    data: [{
                        name: 'مقاله',
                        y: {{ $chart_feed[0] }}
                    }, {
                        name: 'کتاب',
                        y: {{ $chart_feed[1] }}
                    }, {
                        name: 'پایان‌نامه',
                        y: {{ $chart_feed[2] }}
                    }, {
                        name: 'انتشارات',
                        y: {{ $chart_feed[3] }}
                    }, {
                        name: 'پژوهش ها',
                        y: {{ $chart_feed[4] }}
                    }, {
                        name: 'ماهنامه',
                        y: {{ $chart_feed[5] }}
                    }, {
                        name: 'اختراع',
                        y: {{ $chart_feed[6] }}
                    }]
                }]
            });
        });
    </script>
@stop