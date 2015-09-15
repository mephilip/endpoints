<?php
/**
 * Template Name: Auto Quotes Page
 */

\NV\Theme::get_header('special');
\NV\Theme::output_file_marker( __FILE__ );
?>

  <div class="container">
    <div class="col-wrap row">
        <div class="col-main col-sm-11 no-border">

            <div class="content quotes-content">
							<div class="content quotes-content">
  <div class="alert alert-info alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  Auto insurance quotes can vary wildly depending on where you live and from company to company. <strong>Do not</strong> only get one quote before you purchase a car insurance policy. There can be thousands of dollars difference between insurance companies for the exact same coverage.
  </div>              
</div>            </div>
            <?php if (!isset($_GET['zipcode']) && empty($_GET['zipcode'])) { ?>
            <div class="quote-input-wrap surehits-widget text-center">
                <span class="quote-input-label">Enter Your Zip Code</span>
                <form role="search" method="get">
                    <div class="clearfix">
                        <div class="form-group form-group-lg col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                            <input type="text" class="form-control" name="zipcode" placeholder="ex. 10007" value="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg" name="search">Compare rates</button>
                </form>
            </div>
            <?php } ?>
            <?php if (isset($_GET['zipcode']) && !empty($_GET['zipcode'])) { ?>
            <div class="quote-results">
							<?php $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2); $uri = 'http://' . $_SERVER['HTTP_HOST'] . $uri_parts[0]; ?>
                    <script type="text/javascript"> 
	                    /* Reviews.com / Reviews.com - Auto Insurance Clicks */
	                    var MediaAlphaExchange = {     
		                    "type": "ad_unit",
		                    "ua_class": "auto",
		                    "placement_id": "1hgKepAMZvEu7EDq3BG99P6AI-4CbQ",     
		                    "version": "17",     
		                    "sub_1": "<?php echo $uri; ?>",     
		                	"data": {      
								"zip": "<?php echo $_GET['zipcode']; ?>",    
								"currently_insured": "1",
								"current_company": "other",
								"drivers": [
									{
										"sr_22": "0"
									 }
								]   
							}    
		                 }; 
			             </script> <script src="//insurance.mediaalpha.com/js/serve.js"></script>
	                    
	       	</div>
            <div class="col-lg-12 clickback pull-right">
            <a class="pull-right" href="<?php echo $uri; ?>">Search Again</a>
            </div>
            <?php } ?>

            <div class="content quotes-content">
                <h3 style="margin-top: 100px;">Factors That Impact Auto Insurance Quotes and Premiums</h3>
<br>
<h4>Driving History</h4>
<p>
	The single largest factor impacting the price of an auto insurance quote is driving history. Auto insurance companies begin their assessment of prospective customers by looking back at their driving record for things like accidents, traffic violations, or previous insurance claims. The insurance company makes the assumption that a larger number of negative reports equates to a higher level of risk and therefore charges a higher premium for insurance coverage. These negative records typically impact insurance rates for a period of about three years. Maintaining a clean driving record can give a driver access to many more insurance options and ensure discounts that lead to lower car insurance premiums.
</p>
<h4>The Car</h4>
<p>
	Auto insurance premiums reflect variations in cars as well as drivers. One of the primary reasons for this is that more expensive cars simply cost more to fix. A 10-year-old generic car involved in a minor accident can be fixed for a relatively low cost. Repairing a brand new sports car, however, can be very pricey. In addition to the repair bill, car insurance companies know that sports cars often encourage owners to drive faster and more recklessly. Larger vehicles such as SUVs do more damage in the event of an accident but usually keep drivers safer. All of these factors are reflected in the way that insurance companies calculate premiums. The news isn't all bad, however, as the car you drive can also have a positive impact by reducing the cost of insurance. Safety features such as anti-lock brakes and stability control are favored by car insurance companies because they reduce the likelihood or cost of accidents. The availability of these discounts can be an important factor for a cost-conscious auto insurance shopper.
</p>
<h4>The Coverage</h4>
<p>
	Most car insurance companies offer a variety of policy combinations and levels of coverage, all of which impact the cost of a new policy. Laws exist in most states to regulate minimum insurance levels but consumers often elect for additional coverage. In general, a buyer can expect to receive higher auto insurance quotes for higher levels of coverage or for more complete features. For example, collision and comprehensive coverage both offer insurance for your automobile but do so in different ways and for different prices. Collision insurance covers car damage in the event of an accident. Comprehensive coverage provides additional protection from things like vandalism, fire, and other non-collision events. This upgraded policy provides an additional level of protection but can have a significant impact on the price of an insurance policy.
</p>
<h4>Credit Score</h4>
<p>
	One of the less intuitive factors to impact car insurance premium costs is the credit rating of the applicant. Auto insurance companies have done studies that show a correlation between a policyholder's credit score and both their likelihood of filing a claim and the resulting claim size. Though many states are resisting this at the legislative level, car insurance companies offer lower rates to customers with higher credit scores in the vast majority of U.S. jurisdictions.
</p>
<h4>Other Personal Information</h4>
<p>
	Car insurance companies weigh personal factors quite heavily when calculating insurance premiums. Factors like age, gender, occupation, and especially place of residence can all impact a car insurance quote. It's no surprise that actuarial studies have found teenage boys to cause more accidents than 50-year-old women. It's less intuitive but buyers who identify themselves as sales consultants will also pay higher auto insurance premiums. This job is among many that either lead to a higher amount of driving or signal some other element of the high-risk category. Location is also a significant factor as it helps the car insurance company calculate likelihood of vehicle theft, patterns in accidents nearby, and even how much it costs to repair a damaged car in certain areas. Specific counties and states impose regulations on car insurance companies that also impact minimum insurance levels and premium rates.
</p>
            </div>

            <?php if (!isset($_GET['zipcode']) && empty($_GET['zipcode'])) { ?>
                    <div class="quote-input-wrap surehits-widget text-center">
                        <span class="quote-input-label">Enter Your Zip Code</span>
                        <form role="search" method="get">
                            <div class="clearfix">
                                <div class="form-group form-group-lg col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                                    <input type="text" class="form-control" name="zipcode" placeholder="ex. 10007" value="">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg" name="search">Compare rates</button>
                        </form>
                    </div>
            <?php } ?>
        </div>

    </div>

  </div>
  <style type="text/css">
    .quote-results {
		border:none; 
		border-radius:none; 
		padding: 0 0 50px; 
	}
	
	h1.cta {
		font-size: 40px !important;
		text-align: center !important;
	}
	h2.cta {
		font-size: 14px !important;
		text-align:center !important;
	}
	@media only screen and (max-width:992px){
		.quote-results {
			padding:10px 20px;
			border: 1px solid #ccc;
			width:100%;
		}
	}
	.clickback{
		margin: auto;
		margin-bottom: 40px;
		padding:10px 80px;
	}
	
	#new-filter h3{
		margin: 0 !important;
	}
	.quote-input-wrap {
      width: 60%;
      margin: 30px auto;
      padding: 30px 20px 60px;
      border-radius: 7px;
      background-color: rgb(233, 246, 252);
	}
	.btn {
	    font-size:18px;
	    box-shadow:0 2px 5px rgba(0,0,0,.25);
	    background-image:none !important;
	    background-color:orange !important;
	    border-width:1px 1px 4px;
	    border-style:solid;
	    border-color:rgb(223, 116, 1) !important;
	}
	.page-header-title{
	    font-family:flamalight;
	    font-size:26px;
	    margin-bottom:0px;
	}
	h2{
	    font-family: flamalight;
	    font-size: 26px;
	    text-transform: none;
	    margin: 20px 0px 10px;
	}
</style>
<?php
\NV\Theme::get_footer('special');