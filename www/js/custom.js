$(document).ready(function(){
   /**
    * Dark theme for Highcharts JS
    * @author Torstein Honsi
    */

   // Load the fonts
   Highcharts.createElement('link', {
      href: '//fonts.googleapis.com/css?family=Exo+2:400,300,600,700,800',
      rel: 'stylesheet',
      type: 'text/css'
   }, null, document.getElementsByTagName('head')[0]);

   Highcharts.theme = {
      colors: ["#5bcbe7", "#2b908f", "#90ee7e", "#f45b5b", "#7798BF", "#aaeeee", "#ff0066", "#eeaaee",
         "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
      chart: {
         backgroundColor: 'transparent',
         style: {
            fontFamily: "'Exo 2', sans-serif"
         }
      },
      title: {
         style: {
            color: 'rgba(255,255,255,0.8)',
            textTransform: 'uppercase',
            fontSize: '22px',
            fontWeight: 800
         }
      },
      subtitle: {
         style: {
            color: '#E0E0E3',
            textTransform: 'uppercase'
         }
      },
      xAxis: {
         gridLineColor: '#707073',
         labels: {
            style: {
               color: '#E0E0E3'
            }
         },
         lineColor: '#707073',
         minorGridLineColor: '#505053',
         tickColor: '#707073',
         title: {
            style: {
               color: '#b3b3b3',
               fontSize: '11px',
               textTransform: 'uppercase'
            }
         }
      },
      yAxis: {
         gridLineColor: 'rgba(255,255,255,0.1)',
         labels: {
            style: {
               color: '#E0E0E3'
            }
         },
         lineColor: 'red',
         minorGridLineColor: 'red',
         tickColor: 'rgba(255,255,255,0.2)',
         tickWidth: 1,
         title: {
            style: {
               color: '#b3b3b3',
               fontSize: '11px',
               textTransform: 'uppercase'
            }
         }
      },
      tooltip: {
         backgroundColor: 'rgba(0, 0, 0, 0.95)',
         style: {
            color: '#F0F0F0',
            fontSize: '14px',
            lineHeight: '24px',
            padding: '20px'
         }
      },
      plotOptions: {
         column:{
            borderColor: 'transparent',
            borderWidth: 0,
            groupPadding: 0.1
         },
         line:{
            marker:{
               enabled: false
            }
         },
         spline:{
            marker:{
               enabled: false
            }
         },
         area:{
            marker:{
               enabled: false
            }
         },
         areaspline:{
            marker:{
               enabled: false
            }
         },
         series: {
            marker: {
               lineColor: 'red'
            }
         },
         boxplot: {
            fillColor: 'red'
         },
         candlestick: {
            lineColor: 'red'
         },
         errorbar: {
            color: 'red'
         }
      },
      legend: {
         itemStyle: {
            color: '#E0E0E3',
            fontWeight: 400,
            fontSize: '13px'
         },
         itemHoverStyle: {
            color: '#FFF'
         },
         itemHiddenStyle: {
            color: '#606063'
         }
      },
      credits: {
         enabled: false,
         style: {
            color: '#666'
         }
      },
      labels: {
         style: {
            color: '#707073'
         }
      },

      drilldown: {
         activeAxisLabelStyle: {
            color: '#F0F0F3'
         },
         activeDataLabelStyle: {
            color: '#F0F0F3'
         }
      },

      navigation: {
         buttonOptions: {
            symbolStroke: '#DDDDDD',
            theme: {
               fill: '#505053'
            }
         }
      },

      // scroll charts
      rangeSelector: {
         buttonTheme: {
            fill: '#505053',
            stroke: '#000000',
            style: {
               color: '#CCC'
            },
            states: {
               hover: {
                  fill: '#707073',
                  stroke: '#000000',
                  style: {
                     color: 'white'
                  }
               },
               select: {
                  fill: '#000003',
                  stroke: '#000000',
                  style: {
                     color: 'white'
                  }
               }
            }
         },
         inputBoxBorderColor: '#505053',
         inputStyle: {
            backgroundColor: '#333',
            color: 'silver'
         },
         labelStyle: {
            color: 'silver'
         }
      },

      navigator: {
         handles: {
            backgroundColor: '#666',
            borderColor: '#AAA'
         },
         outlineColor: '#CCC',
         maskFill: 'rgba(255,255,255,0.1)',
         series: {
            color: '#7798BF',
            lineColor: '#A6C7ED'
         },
         xAxis: {
            gridLineColor: '#505053'
         }
      },

      scrollbar: {
         barBackgroundColor: '#808083',
         barBorderColor: '#808083',
         buttonArrowColor: '#CCC',
         buttonBackgroundColor: '#606063',
         buttonBorderColor: '#606063',
         rifleColor: '#FFF',
         trackBackgroundColor: '#404043',
         trackBorderColor: '#404043'
      },

      // special colors for some of the
      legendBackgroundColor: 'rgba(0, 0, 0, 0.2)',
      background2: '#505053',
      dataLabelsColor: '#B0B0B3',
      textColor: '#C0C0C0',
      contrastTextColor: '#F0F0F3',
      maskColor: 'rgba(255,255,255,0.3)'
   };

   // Apply the theme
   Highcharts.setOptions(Highcharts.theme);
});

$(document).ready(function(){
   $('select[name="category"]').change(function(){
      window.location = '?category='+$(this).val();
   });
   // var split = window.location.href.split('?category');
   // if (split[1]){
   //    $('html, body').animate({
   //       scrollTop: $('select[name="category"]').offset().top - 100
   //    }, 0);
   // }
});
