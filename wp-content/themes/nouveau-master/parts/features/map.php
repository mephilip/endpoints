<script src='http://insurance.mediaalpha.com/js/serve.js'></script>
<div class="section">	
	<div id="data-map">
		<div class="page-item">
	    	<div class="offset-middle" id="local-authorities">
		    	<h5><?php the_sub_field('pre_header'); ?></h5>
	            <h2><?php the_sub_field('header'); ?></h2>

	    	</div>
		</div>
		  		
		<div id="map-inner" class="page-item" data-equalizer="map-wrap" data-equalizer-mq="large-up">
			<div class="block-left" data-equalizer-watch="map-wrap">
				<div id="map-intro">
									</div>
				<div id="map"></div>
				<div id="map-select">
					<select id="map-option"></select>
				</div>
				
			</div>
			<div class="widget-right" data-equalizer-watch="map-wrap">
				<div class="detail-wrap" data-equalizer="side" data-equalizer-mq="medium-only">
					
					<div class="details" data-equalizer-watch="side">
						<div class="city-details">
							<h3 id='state'>Washington</h3>
						</div>
					</div>
					
					
					
					<div class="details" data-equalizer-watch="side">
						<div class="city-details">
							<h6>Annual Average Premium*</h6>
						</div>
						<div class="city-stats">	
							<div class="stat">
								<div class="left"> State </div>
								<div id="state-premium" class="stat-num"> $1,756 </div>
							</div>
						
							<div class="stat">
								<div class="left"> National Average </div>
								<div id="national-premium" class="stat-num"> $1,670 </div>
							</div>
						</div>
						<small>*Estimates based on 35-year old male with a clean driving record</small>
					</div>
					
					<div class="details" data-equalizer-watch="side">
						<div class="city-details">
							<h6>State Minimum Liability</h6>
						</div>
						<div class="city-stats">	
							<div class="stat">
								<div class="left bold">Bodily Injury</div>
							</div>
							
							<div class="stat indent">
								<div class="left"> Per person </div>
								<div id="per-person" class="stat-num"> $25,000 </div>
							</div>
						
							<div class="stat indent">
								<div class="left"> Per accident </div>
								<div id="per-person" class="stat-num"> $50,000 </div>
							</div>
							<div class="stat">
								<div class="left bold">Property Damage</div>
								<div id="property-damage" class="stat-num"> $10,000 </div>
							</div>
						</div>
					</div>

					<div class="details" data-equalizer-watch="side">
						<div class="city-details">
							<h6 class="no-under">Enter Your Zip For Local Rates</h6>
						</div>
						<div>
							<form id="quote-form"> 
								<input id="zip-code" type="text" class="quote-input" placeholder="ex: 90210"/>
								<small id="quote-error" class="error">Enter Valid Zip Code</small>
								<input type="submit" class="quote-submit button" value="Get Rates"/>
							</form>
						</div>
					</div>
					
					
					
					
					
				</div>
			</div>
			
			<div id="see-more-states">List All States</div>
			
		</div>
		
		<div class="page-item hidden-states">
			<div id="close-hidden-states"><i class="fa fa-times"></i></div>
			<ul>
				<li><a href="<?php get_site_url();?>/auto-insurance/alabama/">Alabama</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/alaska/">Alaska</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/arizona/">Arizona</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/arkansas/">Arkansas</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/california/">California</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/colorado/">Colorado</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/connecticut/">Connecticut</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/delaware/">Delaware</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/florida/">Florida</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/georgia">Georgia</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/hawaii/">Hawaii</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/idaho">Idaho</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/illinois/">Illinois</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/indiana/">Indiana</a></li>
			</ul>
			<ul>
				<li><a href="<?php get_site_url();?>/auto-insurance/indiana">Indiana</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/iowa/">Iowa</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/kansas/">Kansas</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/kentucky/">Kentucky</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/louisiana/">Louisiana</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/maine/">Maine</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/maryland</li>">Maryland</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/massachusetts/">Massachusetts</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/michigan/">Michigan</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/minnesota/">Minnesota</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/mississippi/">Mississippi</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/missouri/">Missouri</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/montana/">Montana</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/nebraska/">Nebraska</a></li>
			</ul>
			<ul>
				<li><a href="<?php get_site_url();?>/auto-insurance/nevada/">Nevada</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/new-hampshire/">New Hampshire</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/new-jersey/">New Jersey</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/new-mexico/">New Mexico</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/new-york/">New York</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/north-carolina/">North Carolina</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/north-dakota/">North Dakota</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/ohio/">Ohio</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/oklahoma/">Oklahoma</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/oregon/">Oregon</li>
				<li><a href="<?php get_site_url();?>/auto-insurance/pennsylvania/">Pennsylvania</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/rhode-island/">Rhode Island</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/south-carolina/">South Carolina</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/south-dakota/">South Dakota</a></li>
			</ul>
			<ul>
				<li><a href="<?php get_site_url();?>/auto-insurance/tennessee/">Tennessee</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/texas/">Texas</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/utah/">Utah</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/vermont/">Vermont</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/virginia/">Virginia</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/washington/">Washington</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/washington-dc/">Washington DC</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/west-virginia/">West Virginia</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/wisconsin/">Wisconsin</a></li>
				<li><a href="<?php get_site_url();?>/auto-insurance/wyoming/">Wyoming</a></li>
			</ul>
		</div>
		
		<div class="page-item city-quotes" data-equalizer>
			<div class="block-equal" data-equalizer-watch>
				<div class="blockquote">
					<p id="map-quote" class="quote">The higher your deductible, the lower the rate you'll pay. A $500 or $1,000 deductible for comprehensive and collision coverage will decrease your premiums. But remember, you'll have to pay the deductible amount if your company repairs your vehicle, so make sure you can afford it.</p>
					<p class="author"><span id="map-name"></span><span id="map-title"></span></p>
					<p id="map-depart" class="author_title">Washington state Office of the Insurance Commissioner</p>
				</div>
			</div>
			
		</div>
	</div>
	
	
<div id="autoModal" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" role="dialog">
  <div id="modal-results"></div>
  	<a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>
</div>