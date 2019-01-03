export default class TickerCommands
{
    /**
     * @constructor
     */
    constructor(
        edtSymbol,
        edtShares,
        txtCompanyName,
        txtExchange,
        txtSector,
        txtPrevious,
        txtOpen,
        txtLast,
        txtHigh,
        txtLow,
        txtClose,
        txtExtended,
        txt52WeekRange,
        txtShareValue,
        edtGraphDate,
        divChart )
    {
        this.edtSymbol = edtSymbol;
        this.edtShares = edtShares;
        this.txtCompanyName = txtCompanyName;
        this.txtExchange = txtExchange;
        this.txtSector = txtSector;
        this.txtPrevious = txtPrevious;
        this.txtOpen = txtOpen;
        this.txtLast = txtLast;
        this.txtHigh = txtHigh;
        this.txtLow = txtLow;
        this.txtClose = txtClose;
        this.txtExtended = txtExtended;
        this.txt52WeekRange = txt52WeekRange;
        this.txtShareValue = txtShareValue;
        this.edtGraphDate = edtGraphDate;
        this.divChart = divChart;
    }

    UnixTimeToLocalString( t )
    {
        let dt = new Date( t );
        return dt.toLocaleString();
    };

    /**
     * DrawChart
     * @param {array} chartData
     * @param {number} previous
     */
    DrawChart( chartData, previous )
    {
        if ( typeof previous === 'undefined' ) {
            previous = 0;
        }

        // Chartist chart
        /*let labels = [];
        let series = [[]];
        for ( let i = 0; i < data.chart.length; ++i ) {
             labels[i] = data.chart[i].label;
             series[0][i] = data.chart[i].close;
        };
        let chartData = {
            labels: labels,
            series: series
        };
        // We are setting a few options for our chart and override the defaults
        let chartOptions = {
            // Don't draw the line chart points
            showPoint: true,
            // Disable line smoothing
            lineSmooth: false
        };
        new Chartist.Line('.ct-chart', chartData, chartOptions);*/

        // Google Charts chart
        // Create the data table.
        var gcData = new google.visualization.DataTable();
        gcData.addColumn( 'string', 'Date' );
        gcData.addColumn( 'number', 'Price' );

        if ( previous !== 0 ) {
            gcData.addColumn( 'number', 'Previous Close' );
        }

        let rows = [[]];
        for ( let i = 0; i < chartData.length; ++i ) {
            if ( previous !== 0 ) {
                rows[i] = [chartData[i].label, chartData[i].close, previous];
            }
            else {
                rows[i] = [chartData[i].label, chartData[i].close];
            }
        };
        gcData.addRows( rows );

        // Set chart options
        var options = {
            title: 'Chart',
            titleTextStyle: {
                color: 'white'
            },
            width: 1100,
            height: 500,
            animation: {
                startup: true,
                duration: 1000,
                easing: 'inAndOut'
            },
            vAxis: {
                format: 'currency',
                textStyle: {
                    fontSize: 10,
                    color: 'white'
                }
            },
            hAxis: {
                /*gridlines: {
                    count: ( chartData.length / 10 )
                },
                minorGridlines: {
                    count: ( chartData.length / 10 )
                },*/
                textStyle: {
                    fontSize: 10,
                    color: 'white'
                }
            },
            backgroundColor: {
                fill: '#3f3f3f'
            },
            fontSize: 14,
            series: {
                1: { lineDashStyle: [20, 4] }
            },
            chartArea: {
                left: 50,
                top: 50,
                right: 25,
                bottom: 50,
                width: '100%',
                height: '100%'
            },
            legend: {
                position: 'bottom',
                textStyle: {
                    fontSize: 14,
                    color: 'white'
                }
            }
        };

        // Instantiate and draw our chart, passing in some options.
        // Material Line Chart - no animation
        //var chart = new google.charts.Line( this.divChart );
        //chart.draw( gcData, google.charts.Line.convertOptions(options) );
        // Classic Line Chart
        var chart = new google.visualization.LineChart( this.divChart );
        chart.draw( gcData, options );
    }

    /**
     * Generate chart
     * @param {string} dateChart chart date format - mm/dd/yyyy
     */
    SymbolChart( dateChart )
    {
        let self = this;

        if ( this.edtSymbol.val().length <= 0 ) {
            return;
        }

        dateChart = dateChart.substr( 6 ) + dateChart.substr( 0, 2 ) + dateChart.substr( 3, 2 );

        let ep = '/tickerChart/';
        let reqData = {
            'symbol': this.edtSymbol.val(),
            'date': dateChart
        };

        let a = $.ajax({
            url: ep,
            method: 'POST',
            crossDomain: false,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            accepts: "application/json",
            data: JSON.stringify( reqData ),
            timeout: 0
        })
        .done( function ( data, textStatus, xhr ) {
            if ( textStatus === "success" ) {
                console.log( data );

                if ( data.chartData.length > 0 ) {
                    self.DrawChart( data.chartData );
                }
            }
        })
        .fail( function ( xhr, textStatus, errorThrown ) {
            console.log( textStatus );
        });
    }

    /**
     * Search for and retrieve symbol data.
     * @param {string} symbol Stock symbol
     * @param {string} shares Amount of shares
     */
    SearchSymbol( symbol, shares )
    {
        let self = this;
        let ep = '/tickerData/';
        let reqData = {
            'symbol': symbol
        };

        let a = $.ajax({
            url: ep,
            method: 'POST',
            crossDomain: false,
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            accepts: "application/json",
            data: JSON.stringify( reqData ),
            timeout: 0
        })
        .done( function ( data, textStatus, xhr ) {
            if ( textStatus === "success" ) {
                console.log( data );

                self.txtCompanyName.empty().html( data.companyName );
                self.txtExchange.empty().html( data.primaryExchange );
                self.txtSector.empty().html( data.sector );
                self.txtPrevious.empty().html( '$' + data.previousClose.toFixed(2) );
                self.txtOpen.empty().html( '$' + data.open.toFixed(2) + ' @ ' +
                    self.UnixTimeToLocalString( data.openTime ) );
                self.txtLast.empty().html( '$' + data.latestPrice.toFixed(2) +
                    ( ( data.change > 0 ) ? ' (+' : ' (' ) + data.change + ')' +
                    ' @ ' + self.UnixTimeToLocalString( data.latestUpdate ) );
                self.txtHigh.empty().html( '$' + data.high.toFixed(2) );
                self.txtLow.empty().html( '$' + data.low.toFixed(2) );
                self.txtClose.empty().html( '$' + data.close.toFixed(2) + ' @ ' +
                    self.UnixTimeToLocalString( data.closeTime ) );
                self.txtExtended.empty().html( '$' + data.extendedPrice.toFixed(2) + ' @ ' +
                    self.UnixTimeToLocalString( data.extendedPriceTime ) );
                self.txt52WeekRange.empty().html( '$' + data.week52Low.toFixed(2) + ' - $' +
                    data.week52High.toFixed(2) );
                self.txtShareValue.empty().html( '$' + ( shares * data.latestPrice ).toFixed(2) );

                if ( data.chart.length > 0 ) {
                    self.edtGraphDate.val('');
                    self.DrawChart( data.chart, data.previousClose );
                }
            }
        })
        .fail( function ( xhr, textStatus, errorThrown ) {
            console.log( textStatus );
        });
    };
}

//export default TickerCommands;
