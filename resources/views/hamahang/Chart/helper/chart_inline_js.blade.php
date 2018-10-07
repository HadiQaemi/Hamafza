<script>
    $(document).ready(function () {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: '{!!  route('hamahang.charts.country_chart') !!}',
            success: function (result) {
                //console.log(jQuery.parseJSON());
                // Create the chart
                Highcharts.chart('container', {
                    chart: {
                        type: 'column',
                        style:{fontFamily:"IranSharp"}
                    },
                    title: {
                        text: 'آمار بازدید کنندگان سایت بر اساس تفکیک کشور-شهر'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: 'میزان موجودیت'
                        },
                        opposite: true
                    },
                    credits: {
                        enabled: false
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
                                format: '{point.y:.1f}'
                            }
                        }
                    },
                    tooltip: {
                        // headerFormat: '{series.name}<br>',
                        // pointFormat: '{point.name}:  <b>{point.y}</b> of total <br/>'
                    },
                    series: [
                        {
                            name: 'country',
                            colorByPoint: true,
                            data: result['country']
                        }
                    ],
                    drilldown: {
                        series: result['city']
                    }
                });
            }
        });
    });
</script>