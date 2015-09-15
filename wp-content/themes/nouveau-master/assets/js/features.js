/**
 * All javascript for featured content sections
 *
 * 
 *
 * 
 * 
 */
(function($){


// For screens medium size and up build the map

if(Foundation.utils.is_medium_up()){ 
    // Map Presets along with data for the choropleth calculations
	var width = 670, height = 520, centered, max_number = 3000;
	var color_domain = [600, 900, 1200, 1500, 1800, 2100, 2400, 2700, 3000, 3300, 3600, 3900];
	var ext_color_domain = [600, 900, 1200, 1500, 1800, 2100, 2400, 2700, 3000, 3300, 3600, 3900];
	var legend_labels = []              
	var color = d3.scale.threshold()
	.domain(color_domain)
	.range([0,.08,.16,.24,.33,.41,.5,.58,.66,.75,.83,.89,1]);
  
    // Projection of the map based on the height and width
	var projection = d3.geo.albersUsa()
	    .scale(820)
	    .translate([width / 2, height / 2]);
	var path = d3.geo.path()
	    .projection(projection);
	
	// Define the zoom behavior for the map
	var zoom = d3.behavior.zoom()
	.scaleExtent([1, 15])
	.on("zoom", zoomed);
	
	// Select the map element and append the svg
	var svg = d3.select("#map").append("svg")
	    .attr("width", width)
	    .attr("height", height)
	    .call(zoom)
	    .on("dblclick.zoom", null)
	    .on("wheel.zoom", null);

	// Defs element for the plus and minus icon that zooms
	svg.append("rect")
	    .attr("class", "background")
	    .attr("width", width)
	    .attr("height", height);
	   	defs = svg.append('svg:defs');
		defs
		    .append('svg:pattern')
		    .attr('id', 'plus-svg')
		    .attr('patternUnits', 'userSpaceOnUse')
		    .attr('width', '20')
		    .attr('height', '20')
		    .append('svg:image')
		    .attr('xlink:href', Variables.theme_url + '/assets/svg/plus.svg')
		    .attr('x', 0)
		    .attr('y', 0)
		    .attr('width', 20)
		    .attr('height', 20);
		defs = svg.append('svg:defs');
		defs
		    .append('svg:pattern')
		    .attr('id', 'minus-svg')
		    .attr('patternUnits', 'userSpaceOnUse')
		    .attr('width', '20')
		    .attr('height', '20')
		    .append('svg:image')
		    .attr('xlink:href', Variables.theme_url + '/assets/svg/minus.svg')
		    .attr('x', 0)
		    .attr('y', 0)
		    .attr('width', 20)
		    .attr('height', 20);
		    
	// Defs element for the hover that displays a drop shadow on each state
	var filter = svg.append("defs")
		.append("filter")
		.attr("id", "drop-shadow")
		.attr("height", "130%")
		.attr("width", "130%");
		filter.append("feGaussianBlur")
		        .attr("in", "SourceAlpha")
		        .attr("stdDeviation", 2)
		        .attr("result", "blur");
		    filter.append("feOffset")
		        .attr("in", "blur")
		        .attr("dx", -1)
		        .attr("dy", 1)
		        .attr("result", "offsetBlur")
		    filter.append("feFlood")
		        .attr("in", "offsetBlur")
		        .attr("flood-color", "#000")
		        .attr("flood-opacity", "0.4")
		        .attr("result", "offsetColor");
		    filter.append("feComposite")
		        .attr("in", "offsetColor")
		        .attr("in2", "offsetBlur")
		        .attr("operator", "in")
		        .attr("result", "offsetBlur");
		
		    var feMerge = filter.append("feMerge");
		
		    feMerge.append("feMergeNode")
		        .attr("in", "offsetBlur")
		    feMerge.append("feMergeNode")
		        .attr("in", "SourceGraphic");
	
	// Create a wrap to allow the legend and the zoom features to display relatively
	var g = svg.append("g")
		.attr("id", "state-wrap");
	
	// Us JSON to build the svg paths
	d3.json(Variables.theme_url + "/assets/json/us-copy.json", function(us) {
		
		// JSON pulled from WP-API to relate state paths to associated data by d3_id
		d3.json(Variables.home_url + "/wp-json/reviews/v1/fetch/map", function(data){
		    var name = {},
		    	shortname = {},
		    	annual_average_premium = {}, 
		    	state_min_bi = {}, 
		    	state_min_per_accident = {},
		    	state_min_pd = {},
		    	post_id = {};
		    	quote = {};
		    	quote_name = {};
		    	quote_title = {};
		    	quote_department = {};
		    data.forEach(function(d,i){
		      name[d.d3_id] = d.name;
		      shortname[d.d3_id] = d.shortname;
		      annual_average_premium[d.d3_id] = d.annual_average_premium;
		      state_min_bi[d.d3_id] = d.state_min_bi;
		      state_min_per_accident[d.d3_id] = d.state_min_per_accident;
		      state_min_pd[d.d3_id] = d.state_min_pd;
		      post_id[d.d3_id] = d.post_id;
		      quote[d.d3_id] = d.quote;
		      quote_name[d.d3_id] = d.quote_name;
		      quote_title[d.d3_id] = d.quote_title;
		      quote_department[d.d3_id] = d.quote_department;
		    });
		    
			g.append("g")
			.attr("id", "states")
			.selectAll("path")
			.data(topojson.feature(us, us.objects.states).features)
			.enter().append("path")
			.attr("d", path)
			.attr("class", "state")
		    .style("fill",function(d) {
	            return "#00ADEF";
	        })
	        .style("opacity", function(d) {
		    	var opacity = annual_average_premium[d.id] / max_number;
		    	return opacity;
		    })
		    .on('mouseover', function(d){
			    svg.selectAll("path").sort(function (a, b) { // select the parent and sort the path's
				      if (a.id != d.id) return -1;               // a is not the hovered element, send "a" to the back
				      else return 1;                             // a is the hovered element, bring "a" to the front
				});
			    d3.select(this).style("filter","url(#drop-shadow)");
		    })
		    .on('mouseout', function(d){
			    d3.select(this).transition().style("filter","none");
		    })
			.on("click", function(d) {
			  	if (d3.event.defaultPrevented) return; // click suppressed

			  	var statename = name[d.id];
			  	$(".marker").each(function (index, element) {
                    var name = $(this).attr("data-name");
                    if(name == statename){
	                   $(this).show(); 
	                } else {
		               $(this).hide();
	                }
                });
			  	
			    
			    
			  	svg.selectAll("path").attr("class", "state");
			 	$(this).attr("class", "active-state");
			  	$('#state').html(name[d.id]);
				$('#state-premium').html("$" + comma_valued(annual_average_premium[d.id]));
				$('#per-person').html("$" + comma_valued(state_min_bi[d.id]));
				$('#per-accident').html("$" + comma_valued(state_min_per_accident[d.id]));
				$('#property-damage').html("$" + comma_valued(state_min_pd[d.id]));
				$('#map-quote').html(quote[d.id]);
				if(quote_name[d.id] != ''){
					$('#map-name').html(quote_name[d.id] + ", ");
					$('#map-title').html(quote_title[d.id]);
				} else {
					$('#map-name').html('');
					$('#map-title').html('');
				}
				$('#map-depart').html(quote_department[d.id]);
				d3.selectAll(".state").style("fill",function(d) {
		            return "#00ADEF";
		        })
		        d3.select('#state-borders').style("fill","none");
				//d3.select(this).style("fill","url(#tile-ww)");
				//d3.selectAll("path").attr("class", "state");
				//d3.select(this).attr("class", "active-state");
			});
			
			
			  g.append("path")
			  .datum(topojson.mesh(us, us.objects.states, function(a, b) { return a !== b; }))
			  .attr("id", "state-borders")
			  .attr("d", path);
			  
			  var legend = svg.selectAll("g.legend")
			  .data(ext_color_domain)
			  .enter().append("g")
			  .attr("class", "legend");
			
			  var ls_w = 56, ls_h = 12;
			
			  legend.append("rect")
			  .attr("y", 480)
			  .attr("x", function(d, i){ 
				  return i * ls_w;
			  })
			  .attr("width", ls_w)
			  .attr("height", ls_h)
			  .style("opacity", function(d, i) { return color(d); })
			  .style("fill", "#00ADEF");
			  
			  var zoomwrap = svg.selectAll("g.zoom-wrap")
			  .data(["1"])
			  .enter().append("g")
			  .attr("class", "plus-minus-wrap");
			
			  var ls_w = 20, ls_h = 40;
			
			  zoomwrap.append("rect")
			  .attr("x", 0)
			  .attr("y", function(d, i){ 
				  return i * ls_w;
			  })
			  .attr("width", ls_w)
			  .attr("height", ls_h)
			  .attr("fill", '#fff')
			  .style("opacity", 0.9);
			  
			  var zoomFeature = svg.selectAll("g.zoom")
			  .data(["1","2"])
			  .enter().append("g")
			  .attr("class", "plus-minus");
			
			  var ls_w = 20, ls_h = 20;
			
			  zoomFeature.append("rect")
			  .attr("x", 0)
			  .attr("y", function(d, i){ 
				  return i * ls_w;
			  })
			  .attr("width", ls_w)
			  .attr("height", ls_h)
			  .attr("fill", function(d, i){ 
				  if(i == 1){
					return 'url(#minus-svg)';
				  } else {
					return 'url(#plus-svg)';
				  }
			  })
			  .attr("id", function(d, i){ 
				  if(i == 1){
					return 'zoom_out';
				  } else {
					return 'zoom_in';
				  }
			  })
			 .attr("stroke","rgba(0,0,0,.1)")
			  .style("opacity", 0.8)
			  .style("cursor", "pointer")
			  .on('click', zoomClick);
			  
			var legendrect = svg.selectAll("g.legendrect")
			  .data(["1"])
			  .enter().append("g")
			  .attr("class", "legendrect");
  
			  
			  legendrect.append("rect")
			  .attr("x", 0)
			  .attr("y", 492)
			  .attr("fill","#fff")
			  .attr("height","34px")
			  .attr("width", width);
  
			  
			var legendtext = svg.selectAll("g.legendtext")
			  .data(["1"])
			  .enter().append("g")
			  .attr("class", "legendtext");
  
			  
			  legendtext.append("text")
			  .attr("x", 0)
			  .attr("y", 519)
			  .attr("class", "legendtext")
			  .text(function(d, i){ return '$100' })
			  .attr("text-anchor","left");
			  
			  legendtext.append("text")
			  .attr("x", 630)
			  .attr("y", 519)
			  .attr("class", "legendtext")
			  .text(function(d, i){ return '$3,000' })
			  .attr("text-anchor","right");
			  
			  legendtext.append("text")
			  .attr("x", 335)
			  .attr("y", 519)
			  .attr("class", "legendtext-national")
			  .text(function(d, i){ return 'National Average Annual Premium $1,670' })
			  .attr("text-anchor","middle");
			  
			var legendline = svg.selectAll("g.legendline")
			  .data(["1","2"])
			  .enter().append("g")
			  .attr("class", "legendline");
  
			  
			  legendline.append("line")
                .attr("x1", 0)
                .attr("x2", 0)
                .attr("y1", 480)
                .attr("y2", 505)
                .attr('class', 'legend-line')
                .attr("stroke-width", "1px")
                .attr("stroke", "black")

			  
			  legendline.append("line")
			  	.attr("x1", 670)
                .attr("x2", 670)
                .attr("y1", 480)
                .attr("y2", 505)
                .attr('class', 'legend-line')
                .attr("stroke-width", "1px")
                .attr("stroke", "black")
                
              legendline.append("line")
			  	.attr("x1", 335)
                .attr("x2", 335)
                .attr("y1", 480)
                .attr("y2", 505)
                .attr('class', 'legend-line')
                .attr("stroke-width", ".2px")
                .attr("stroke", "black")
			
			g.selectAll("image")
			    .data(topojson.feature(us, us.objects.states).features)
			    .enter()
			    .append("svg:image")
				    .attr('xlink:href', Variables.theme_url + '/assets/svg/pin.svg')
				    .attr("width", 40)
				    .attr("height", 42)
				    .attr("class","marker")
				    .attr("text-anchor","middle")

			    .attr('data-name', function(d){
			        return name[d.id];
			    })
			    .style('display', function(d){
				    if(name[d.id] == "Washington"){
					    return 'block';
				    } else {
					    return 'none';
				    }
			    })
			    .attr("x", function(d){
			        return path.centroid(d)[0] - 20;
			    })
			    .attr("y", function(d){
			        return  path.centroid(d)[1] - 37; 
			    })
			    .attr("text-anchor","middle");
			
			});
	});
}


// Special functions to help the formatting of svg elements and data
function zoomed() {
    g.attr("transform",
        "translate(" + zoom.translate() + ")" +
        "scale(" + zoom.scale() + ")"
    );
}

function zoomedtwo() {
    g.attr("transform",
        "translate(" + zoom.translate() + ")" +
        "scale(" + zoom.scale() + ")"
    );
}

function interpolateZoom (translate, scale) {
    var self = this;
    return d3.transition().duration(350).tween("zoom", function () {
        var iTranslate = d3.interpolate(zoom.translate(), translate),
            iScale = d3.interpolate(zoom.scale(), scale);
        return function (t) {
            zoom
                .scale(iScale(t))
                .translate(iTranslate(t));
            zoomedtwo();
        };
    });
}

function zoomClick() {
    var clicked = d3.event.target,
        direction = 1,
        factor = 1,
        target_zoom = 1,
        center = [width / 2, height / 2],
        extent = zoom.scaleExtent(),
        translate = zoom.translate(),
        zoom_scale = zoom.scale(),
        translate0 = [],
        l = [],
        view = {x: translate[0], y: translate[1], k: zoom.scale()};
		console.log(zoom_scale);
    d3.event.preventDefault();
    direction = (this.id === 'zoom_in') ? 1 : -1;
    target_zoom = zoom_scale + direction;
    if(target_zoom <= 1){
	    target_zoom = 1;
    }
    if(target_zoom >= 15){
	    target_zoom = 15;
    }

    if (target_zoom < extent[0] || target_zoom > extent[1]) { return false; }

    translate0 = [(center[0] - view.x) / view.k, (center[1] - view.y) / view.k];
    view.k = target_zoom;
    l = [translate0[0] * view.k + view.x, translate0[1] * view.k + view.y];

    view.x += center[0] - l[0];
    view.y += center[1] - l[1];

    interpolateZoom([view.x, view.y], view.k);
}



function comma_valued(number_format){
	var new_format = number_format.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	return new_format;
}
		

$('#quote-form').bind('submit', function(e){
	e.preventDefault();
	var zip = $('#zip-code').val();
	var quote_error = $('#quote-error');
	var modal_results = $('#modal-results');
	var isValidZip = /(^\d{5}$)|(^\d{5}-\d{4}$)/.test(zip);
	if(isValidZip){
		MediaAlphaExchange = {
				'type': 'ad_unit',
				'ua_class': 'auto',
				'placement_id': '1hgKepAMZvEu7EDq3BG99P6AI-4CbQ',
				'version': '17',
				'sub_1': Variables.current_url,
				'sub_2': 'Map',
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
		$('#autoModal').foundation('reveal','open');
		
		
		var check_results = function(){
		   if(!modal_results.has( "div" ).length){
			 	modal_results.html("Nothing found, please try again.");
			}
		};
		setTimeout(check_results, 1000);
		
		
	} else {
		quote_error.css('display','inline-block');
		$(document).foundation('equalizer','reflow');
	}
	
});

$('#see-more-states').bind('click', function(e){
	$('.hidden-states').slideDown();
	$(this).hide();	
});

$('#close-hidden-states').bind('click', function(e){
	$('.hidden-states').slideUp('', function() {
	    $('#see-more-states').show();
	});
		
});



// Mobile interworkings of the map functions 
$(window).on('load resize', function () {
	// Load JSON and build select element only is screen size is small
	if(Foundation.utils.is_small_only()){
		$.getJSON(Variables.home_url + "/wp-json/reviews/v1/fetch/map", function(data) {
		    json = data;	    	    
		}).done(function(){
			
			function displayJson(){
				var states = [];
			    $.each(json, function(key, val) {
				    // Create our option for the select input
				    cur_state = val.name;
			        states.push("<option value='" + cur_state + "'>" + cur_state + "</li>");
			        
			        // Build our object to interact with on change
			        
			        
			    });
			    var select_states = states.join("");
			    $('#map-option').append(select_states);
			}
			
			function sortJsonField(){
	
			    function sortJson(a,b){
			        return a.name > b.name ? 1 : -1;
			    }	
				json.sort(sortJson);
		
				displayJson();
			};
			
			sortJsonField();
		});
		
		$( "#map-option" ).change(function () {
		    var str = "";
		    $( "select option:selected" ).each(function() {
		      	str += $( this ).val();
		    });
		    function comma_valued(number_format){
				var new_format = number_format.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				return new_format;
			}
		    $.getJSON(Variables.home_url + "/wp-json/reviews/v1/fetch/map", function(data) {
		    	json = data;	    	    
			}).done(function(){
				
				$.each(json, function(key, val) {
				    
				    cur_state = val.name;
			        if(cur_state == str){
				        
				        $('#state').html(cur_state);
						$('#state-premium').html("$" + comma_valued(val.annual_average_premium));
						$('#per-person').html("$" + comma_valued(val.state_min_bi));
						$('#per-accident').html("$" + comma_valued(val.state_min_per_accident));
						$('#property-damage').html("$" + comma_valued(val.state_min_pd));
						$('#map-quote').html(val.quote);
						if(val.quote_name != ''){
							$('#map-name').html(val.quote_name + ", ");
							$('#map-title').html(val.quote_title);
						} else {
							$('#map-name').html('');
							$('#map-title').html('');
						}
						$('#map-depart').html(val.quote_department);

		                $(document).foundation('equalizer', 'reflow');
			        }		        
			        
			    });
				
			});
	  	}).change();		
	}
});









})(jQuery);








(function(){
  var DEFAULT_HEIGHT = 300,
      DEFAULT_WIDTH = 600,
      DEFAULT_BOTTOM_PERCENT = 1/3,
      DEFAULT_OFFSET = -200,
      DEFAULT_TRANSLATE = 400;
 

  window.FunnelChart = function(options) {
    /* Parameters:
      data:
        Array containing arrays of categories and engagement in order from greatest expected funnel engagement to lowest.
        I.e. Button loads -> Short link hits
        Ex: [['Button Loads', 1500], ['Button Clicks', 300], ['Subscribers', 150], ['Shortlink Hits', 100]]
      width & height:
        Optional parameters for width & height of chart in pixels, otherwise default width/height are used
      bottomPct:
        Optional parameter that specifies the percent of the total width the bottom of the trapezoid is
        This is used to calculate the slope, so the chart's view can be changed by changing this value
    */

    this.data = options.data;
    this.totalEngagement = 0;
    for(var i = 0; i < this.data.length; i++){
      this.totalEngagement += this.data[i][1];
    }
    this.width = typeof options.width !== 'undefined' ? options.width : DEFAULT_WIDTH;
    this.height = typeof options.height !== 'undefined' ? options.height : DEFAULT_HEIGHT;
    this.offset = typeof options.offset !== 'undefined' ? options.offset : DEFAULT_OFFSET;
    var translate = typeof options.translate !== 'undefined' ? options.translate : DEFAULT_TRANSLATE;
    var bottomPct = typeof options.bottomPct !== 'undefined' ? options.bottomPct : DEFAULT_BOTTOM_PERCENT;
    this._slope = 2*this.height/(this.width - bottomPct*this.width);
    this._totalArea = (this.width+bottomPct*this.width)*this.height/2;
  };

  window.FunnelChart.prototype._getLabel = function(ind){
    /* Get label of a category at index 'ind' in this.data */
    return this.data[ind][0];
  };
  
  window.FunnelChart.prototype._getLabelId = function(ind){
    var str = this.data[ind][0].replace(/[^A-Z0-9]+/ig, "_");
    return str;
  };

  window.FunnelChart.prototype._getEngagementCount = function(ind){
    /* Get engagement value of a category at index 'ind' in this.data */
    return this.data[ind][1];
  };
  
   window.FunnelChart.prototype._getTranslate = function(ind){
    /* Get engagement value of a category at index 'ind' in this.data */
    return this.translate;
  };

  window.FunnelChart.prototype._createPaths = function(){
    /* Returns an array of points that can be passed into d3.svg.line to create a path for the funnel */
    trapezoids = [];

    function findNextPoints(chart, prevLeftX, prevRightX, prevHeight, dataInd){
      // reached end of funnel
      if(dataInd >= chart.data.length) return;

      // math to calculate coordinates of the next base
      area = chart.data[dataInd][1]*chart._totalArea/chart.totalEngagement;
      prevBaseLength = prevRightX - prevLeftX;
      nextBaseLength = Math.sqrt((chart._slope * prevBaseLength * prevBaseLength - 4 * area)/chart._slope);
      nextLeftX = (prevBaseLength - nextBaseLength)/2 + prevLeftX;
      nextRightX = prevRightX - (prevBaseLength-nextBaseLength)/2;
      nextHeight = chart._slope * (prevBaseLength-nextBaseLength)/2 + prevHeight;

      points = [[nextRightX, nextHeight]];
      points.push([prevRightX, prevHeight]);
      points.push([prevLeftX, prevHeight]);
      points.push([nextLeftX, nextHeight]);
      points.push([nextRightX, nextHeight]);
      trapezoids.push(points);

      findNextPoints(chart, nextLeftX, nextRightX, nextHeight, dataInd+1);
    }

    findNextPoints(this, 0, this.width, 0, 0);
    return trapezoids;
  };

  window.FunnelChart.prototype.draw = function(elem, speed){
    var DEFAULT_SPEED = 0;
    speed = typeof speed !== 'undefined' ? speed : DEFAULT_SPEED;

    var funnelSvg = d3.select(elem).append('svg:svg')
              .attr('width', 1000)
              .attr('height', this.height)
              .attr('id', 'funnel-graph')
              .append('svg:g')
              .attr('id','funnel-translate')
              .attr('style', 'transform:translate(' + DEFAULT_TRANSLATE + 'px,0px)');
              
              defs = funnelSvg.append('svg:defs');
			  defs
			    .append('svg:pattern')
			    .attr('id', 'funnel-stripes')
			    .attr('patternUnits', 'userSpaceOnUse')
			    .attr('width', '32')
			    .attr('height', '32')
			    .append('svg:image')
			    .attr('xlink:href', Variables.theme_url + '/assets/images/diag-pat.png')
			    .attr('x', 0)
			    .attr('y', 0)
			    .attr('width', 32)
			    .attr('height', 32);

    // Creates the correct d3 line for the funnel
    var funnelPath = d3.svg.line()
                    .x(function(d) { return d[0]; })
                    .y(function(d) { return d[1]; });


    var paths = this._createPaths();

    function drawTrapezoids(funnel, i){
      var trapezoid = funnelSvg
                      .append('svg:path')
                      .attr('d', function(d){
                        return funnelPath(
                            [paths[i][0], paths[i][1], paths[i][2],
                            paths[i][2], paths[i][1], paths[i][2]]);
                      })
                      .attr('data-relate', function(d){
	                      return funnel._getLabelId(i);
                      })
                      .attr('class', 'funnel-part')
                      .attr('data-relate', function(d){
	                       	return funnel._getLabelId(i);
                      })
                      .on('mouseover', function(d){
	                       	
                      })
                      .on('click', function(d){
	                      d3.selectAll('.funnel-part').attr("class",'funnel-part');
	                      d3.selectAll('.funnel-part').attr("data-class",'no-transform');
	                      d3.select(this).attr("data-class",'yes-transform');
	                      d3.selectAll('.funnel-part').style("transform", "translateX(0px)");
	                      $(".funnel-part").each(function (index, element) {
		                  	$(this).attr('fill', 'url(#funnel-stripes)')
		                  });	                       	
	                      d3.select(this).style("transform", "translateX(-30px)");	
	                      
	                      d3.select(this).attr('fill', '#21aeec');	                       	
	                      var path_id = funnel._getLabelId(i);
	                      $(".funnel-text-number").each(function (index, element) {
			                    var name = $(this).attr("data-relate");
			                    if(name == path_id){
				                   $(this).attr("x","270").attr("fill", "#fff"); 
				                } else {
				                   $(this).attr("x","300").attr("fill", "#000"); 
				                }
			              });
			              $(".funnel-line").each(function (index, element) {
			                    var name = $(this).attr("data-relate");
			                    var cur_x = $(this).attr("x2");
			                    var clicked = $(this).attr("clicked");
			                    
			                    if(name == path_id){
				                   if(clicked == "yes"){
					                   
				                   } else {
					                   $(this).attr("clicked", "yes");
					                   $(this).attr("x2", cur_x - 30);
				                   }
				                } else {
					                var new_x = funnel.width/2.15;
					                console.log(new_x);
			                    	$(this).attr("x2", new_x);
			                    	$(this).attr("clicked", "no");
				                }
			              });
			              
			              $('.funnel-reveal').hide();
					      var current_id = "#" + path_id;
					      $(current_id).fadeIn();
	                                            	
                      })
                      .on('mouseout', function(d){

                      });

      nextHeight = paths[i][[paths[i].length]-1];

      var totalLength = trapezoid.node().getTotalLength();

      var transition = trapezoid
                      .transition()
                        .duration(0)
                        .ease("linear")
                        .attr("d", function(d){return funnelPath(paths[i]);})
                        .attr('fill', 'url(#funnel-stripes)');
                        
                        

      funnelSvg
      .append('svg:text')
      .text(funnel._getEngagementCount(i))
      .attr('class', 'funnel-text-number')
      .attr("x", function(d){ return funnel.width/2; })
      .attr("y", function(d){
        return (paths[i][0][1] + paths[i][1][1])/2;}) // Average height of bases
      .attr("text-anchor", "middle")
      .attr("dominant-baseline", "middle")
      .attr("fill", "#000")
      .attr('data-relate', function(d){
          return funnel._getLabelId(i);
      });
      
      funnelSvg
      .append('svg:text')
      .text(funnel._getLabel(i))
      .attr('class', 'funnel-text')
      .attr("x", function(d){ return funnel.offset; })
      .attr("y", function(d){
        return (paths[i][0][1] + paths[i][1][1])/2 - 10;}) // Average height of bases
      .attr("text-anchor", "left")
      .attr("dominant-baseline", "middle")
      .attr("fill", "#000")
      .attr('data-relate', function(d){
          return funnel._getLabelId(i);
      });
      
      funnelSvg.append("line")
                         .attr("y1", function(d){
        return (paths[i][0][1] + paths[i][1][1])/2;}) // Average height of bases
                         .attr("y2", function(d){
        return (paths[i][0][1] + paths[i][1][1])/2;}) // Average height of bases
                        .attr("x1", funnel.offset)
                        .attr("x2", funnel.width/2.15)
                        .attr('class', 'funnel-line')
                        .attr("stroke-width", ".3px")
                        .attr("stroke", "black")
                        .attr('data-relate', function(d){
					          return funnel._getLabelId(i);
					    });

      if(i < paths.length - 1){
        transition.each('end', function(){
          drawTrapezoids(funnel, i+1);
        });
      }
    }

    drawTrapezoids(this, 0);
  };
})();


	    var chart = new FunnelChart({
	    				data: funnelData,
	    				width: 600, 
	    				height: 420, 
	    				bottomPct: 1/1000,
	    				offset: -300,
	    			});
	    chart.draw('#funnelContainer', 10);
        
    
	jQuery.fn.d3Click = function () {
	  this.each(function (i, e) {
	    var evt = document.createEvent("MouseEvents");
	    evt.initMouseEvent("click", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
	
	    e.dispatchEvent(evt);
	  });
	};

$(window).on('load resize', function () {
	 var path_id = d3.select('.funnel-part').attr('data-relate');
	 d3.select('.funnel-part').style("transform", "translateX(-30px)").attr('fill', '#21aeec').attr("data-class","yes-transform");
	 $(".funnel-text-number").each(function (index, element) {
            var name = $(this).attr("data-relate");
            if(name == path_id){
               $(this).attr("x","270").attr("fill", "#fff"); 
            } 
      });
      var funnel, width;
      $(".funnel-line").each(function (index, element) {
            var name = $(this).attr("data-relate");
            var cur_x = $(this).attr("x2");
            var clicked = $(this).attr("clicked");
            
            if(name == path_id){
               if(clicked == "yes"){
                   
               } else {
                   $(this).attr("clicked", "yes");
                   $(this).attr("x2", cur_x - 30);
               }
            } 
      });
      
      $('.funnel-reveal').hide();
      var current_id = "#" + path_id;
      $(current_id).show();
});
