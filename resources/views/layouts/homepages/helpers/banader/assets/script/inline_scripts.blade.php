@if(session('message')!='')
    <script>
        jQuery.noticeAdd({
            text: '{{ session('message') }}',
            stay: false,
            type: '{{ session("mestype") }}'
        });
    </script>
@endif

<script>
    $(document).ready(function () {
        $("#TagRes").mCustomScrollbar();
    });
    $(function () {
        $("#KeywordFehresrt").jstree({
            "plugins": ["search"]
        });
        var to = false;
    });
    $('#KeywordFehresrt').jstree({
        "plugins": ["search"],
        'core': {
            'data': [
                @if(isset($keywordTab))
                {!! $keywordTab  !!}
                @endif
            ],
            'rtl': true,
            "themes": {
                "icons": false
            }
        }
    });
    $("#KeywordFehresrt")
        .bind('select_node.jstree',
            function (e, data) {
                var texts = data.node.text;
                var ids = data.node.id;
                $("#Navigatekeywords").tokenInput("add", {id: ids, name: texts});
                $("#TagRes").animate({
                    scrollTop: 0
                }, 600);
            })
        .on("activate_node.jstree", function (e, data) {
            window.location.href = data.node.a_attr.href;
            history.pushState("", document.title, window.location.pathname + window.location.search);
        });

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

    $(document).on('shown.bs.modal', function() {
        $("#header").attr('style','position: fixed;width: 100%;z-index: 1;');
    });
    $(document).on('hide.bs.modal', function() {
        $("#header").attr('style','position: fixed;z-index: 10000;width: 100%;');
    });
</script>