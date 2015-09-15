/**
 * STATE PAGE JAVASCRIPT FILE
 */

 function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

(function($){
	if ($('#main_chart')) {
		var state_abbrev = $('.state-abbrev').data('stateabbrev');
		$.getJSON(Variables.home_url + '/wp-json/reviews/v1/fetch/state/' + state_abbrev, function(data) {
			console.log(data);
			var avg_annual_premium = data.avg_annual_premium;
			var city_data = data.city_data;
			var cities = [], premiums = [];
			$(data.city_data).each(function() {
				cities.push(this.city);
				premiums.push(parseInt(this.avg_annual_premium));
			});

			var low_premium = Math.min.apply(Math,premiums);

			var state_name = data.state_name;

			Highcharts.setOptions({
				lang: {
					thousandsSep: ','
				}
			});

			$('#main_chart').highcharts({
			  chart: {
		      type: 'bar'
			  },
			  title: {
		      text: ''
			  },
			  xAxis: {
		      categories: cities,
			  },
			  yAxis: {
			      min: low_premium - 200,
			      title: {
		          text: ' ',
		          align: 'high'
			      },
			      plotLines: [{
		          color: 'red',
		          value: avg_annual_premium,
		          width: '2',
		          zIndex: 4,
		          label: {
		          	useHTML: true,
		          	rotation: 0,
		          	text: state_name + ' Average Yearly Rate<br><b>$' + addCommas(avg_annual_premium) + '</b>',
		          	x: 5,
		          	align: 'left'
		          }
			      }]
			  },
			  tooltip: {
			  	pointFormat: '{series.name}<b>${point.y}</b>'
			  },
			  legend: { enabled: false },
			  exporting: { enabled: false },
			  credits: { enabled: false },
			  plotOptions: {
			      series: {
			          pointWidth: 20
			      }
			  },
			  series: [{
		      name: ' ',
		      color: '#00ADEF',
		      data: premiums
			  }]
			});
		});
	}

  $('.graph').each(function() {
    $(this).find('.graph').each(function() {
      var percentage = Math.round($(this).data('value')/$(this).data('max') * 100);
      if ($(this).hasClass('bar')) {
        $(this).width(percentage+'%');
      } else {
        $(this).height(percentage+'%');
      }
    });
  });

  $('.quote-form form').bind('submit', function(e){
  	e.preventDefault();
  	var zip = $(this).find('#zip-code').val();
  	var quote_error = $(this).find('#quote-error');
  	var modal_results = $('#modal-results');
  	var isValidZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(zip);
  	var sub_2 = $(this).parent().data('label');
  	if(isValidZip){
  		MediaAlphaExchange = {
  				'type': 'ad_unit',
  				'ua_class': 'auto',
  				'placement_id': '1hgKepAMZvEu7EDq3BG99P6AI-4CbQ',
  				'version': '17',
  				'sub_1': Variables.current_url,
  				'sub_2': sub_2,
  				'data': {
  					'zip': zip,
  					'currently_insured': '1',
  					'current_company': 'other',
  					'drivers': [ {
  						'sr_22': '0'
  						}
  					]
  				}
  		};
  		modal_results.html('Loading ...');
  		quote_error.css('display','none');
  		MediaAlphaExchange__load('modal-results');
  		$('#modal').foundation('reveal','open');
  		
  		
  		var check_results = function(){
  		   if(!modal_results.has( "div" ).length){
  			 	modal_results.html("Nothing found, try again.");
  			}
  		};
  		setTimeout(check_results, 1000);
  		
  		
  	} else {
  		quote_error.css('display','inline-block');
  		$(document).foundation('equalizer','reflow');
  	}
  	
  });

})(jQuery);
