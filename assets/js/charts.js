/**
 * Created by root on 29.01.15.
 */


$(document).ready(function() {

    $('#daterange').daterangepicker({
        format: 'YYYY-MM-DD',
        showDropdowns: true,
        /*ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },*/
        opens: 'left',
        buttonClasses: ['btn btn-small'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
        format: 'DD.MM.YYYY',
        separator: ' to ',
        locale: {
            applyLabel: 'Выбрать',
            cancelLabel: 'Очистить',
            fromLabel: 'От',
            toLabel: 'До',
            customRangeLabel: 'Кастом',
            daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт','Сб'],
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            firstDay: 1
        }
    },
    function(start, end, label) {
        $('#year option:selected').removeAttr('selected');
    });

    updateChartMonths( 'ANSWER',  2014, 0);
    updateChartYear( 'ANSWER', 2014, 0);

    $("#callsForm").submit(function() {

        var year = $('#year option:selected').val();
        var type = $('#type option:selected').val();
        var daterange = $('#daterange').val();
        var gatway = $('#gatway').val();

        updateChartMonths( type, year, daterange, gatway);
        updateChartYear( type, year, daterange, gatway);
        return false; // avoid to execute the actual submit of the form.
    });

    $('#year').on('change', function() {
        $('#daterange').val('');
    });
});

function generateTable( data ){
    $('#chartMonthsTable').html('');

    var months = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    var html = '<table class="display"><thead><tr><th>Месяц</th><th>Час</th><th>Звонки</th></tr></thead><tbody>';
    console.log(data);
    var lenghtData = data.length;
    for( var i=0; i<lenghtData; i++){

        var hour = data[i].name;
        var lengthMonth = data[i].data.length;

        for(var j=0; j<lengthMonth; j++ ){
            var month = j;
            var calls = data[i].data[j];

            html += '<tr><td>'+months[month]+'</td><td>'+hour+'</td><td>'+calls+'</td></tr>';
        }

    }

    html += '</tbody></table>';
    $('#chartMonthsTable').append(html);
    $('#chartMonthsTable table').DataTable();
}

function updateChartMonths(type, year, daterange, gatway ){

    $.getJSON( "/data", { type: type, year: year, daterange:daterange , gatway: gatway } )
        .done(function( json ) {

            generateTable( json );

            $('#chartMonths').highcharts({
                chart: { type: 'column' },
                title: {  text: 'График звонков - средние' },
                subtitle: { text: 'По часам за каждый месяц' },
                xAxis: {
                    categories: ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'
                    ]
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Звонки (раз)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: json
            });
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
        });

}

function updateChartYear(type, year, daterange, gatway ){

    $.getJSON( "/datayear", { type: type, year: year, daterange:daterange, gatway: gatway } )
        .done(function( json ) {

            $('#chartYear').highcharts({
                chart: { type: 'column' },
                title: { text: 'График звонков - средние' },
                subtitle: { text: 'По часам за года' },
                xAxis: { categories: ['2012','2013','2014'] },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Звонки (раз)'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: json
            });
        })
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            console.log( "Request Failed: " + err );
        });
}