<?php
namespace NV\Custom;

/**
 * 
 * Custom Functions class
 *
 */
class Functions extends \NV\Theme {

	/**
	 * Responsible for outputting facebook social images in header file
	 */
	public static function facebook_og_images() {
		global $post;
		if( have_rows('facebook_og_images', $post->ID) ):
		    while ( have_rows('facebook_og_images', $post->ID) ) : the_row();		    	
		    	$facebook_image = get_sub_field('image');
		    	echo "<meta property='og:image' content='$facebook_image'/>\n";
		    endwhile;
		else:
		endif;
	}

	/**
	 * Removes the standard WYSIWYG editor
	 */
	public static function reset_editor() {
		global $_wp_post_type_features;
		if ( isset($_wp_post_type_features['page']['editor']) ) {
			unset($_wp_post_type_features['page']['editor']);
		}
	}

	/**
	 * Enqueues correct google fonts to be loaded
	 */
	public static function google_fonts() {
		$query_args = array(
			'family' => 'Shadows+Into+Light',
			'subset' => 'latin,latin-ext',
		);
		wp_register_style( 'google_fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
    }
  

	/**
	 * Runs the shortcode
	 */
	public static function process_textarea_shortcodes( $value, $post_id, $field ) {
		// run do_shortcode on all textarea values
		$value = do_shortcode($value);
		
		// return
		return $value;
	}

	/**
	 * Loops to handle processing of ACF content.
	 * Multiple functions needed to handle each level of the loop.
	 */
	// Process the flexible content layout
	public static function process_content() {
		if (get_field('flexible_content')) {
			while (has_sub_field('flexible_content')) {
				\NV\Theme::loop( 'parts/section' );
			}
		}
	}
	// Process the flexible content sections
	public static function process_section() {
		if (get_sub_field('section_content')) {
			while (has_sub_field('section_content')) {
				get_template_part ( 'parts/features/'.get_row_layout() );
			}
		}
	}
	// Process the flexible content text block sidebars
	public static function process_sidebar() {
		if (get_sub_field('sidebar')) {
			while (has_sub_field('sidebar')) {
				get_template_part ( 'parts/sidebars/'.get_row_layout() );
			}
		}
	}

	/**
	 * Shortcodes
	 */
	public static function blockquote_shortcode($atts, $content = null) {
		$out = '<div class="blockquote">';
		$out .= '	<p class="quote">'.$atts['quote'].'</p>';
		$out .= '	<p class="author">'.$atts['author'].'</p>';
		$out .= '	<p class="author_title">'.$atts['author_title'].'</p>';
		$out .= '</div>';

		return $out;
	}

	public static function state_ins_minimum_shortcode($atts, $content = null) {
		global $state_data;
		$out = '<div class="insurance-minimums">';
		$out .= '	<p class="header">Bodily Injury</p>';
		$out .= '	<div class="stat-row">';
		$out .= '		<div class="stat">';
		$out .= '			<div class="number">$'.$state_data->bi_per_person.'k</div>';
		$out .= '			<div class="text">per person</div>';
		$out .= '		</div>';
		$out .= '		<div class="stat">';
		$out .= '			<div class="number">$'.$state_data->bi_per_accident.'k</div>';
		$out .= '			<div class="text">per accident</div>';
		$out .= '		</div>';
		$out .= '	</div>';
		$out .= '	<p class="header">Property Damage</p>';
		$out .= '	<div class="stat-row">';
		$out .= '		<div class="stat">';
		$out .= '			<div class="number">$'.$state_data->pd_limit.'k</div>';
		$out .= '		</div>';
		$out .= '	</div>';
		$out .= '</div>';

		return $out;
	}

	public static function state_comp_marketshare_shortcode ($atts, $content = null) {
		global $state_data;
		$out = '<div class="company-marketshare">';
		$out .= '<ul>';
		foreach ($state_data->company_data as $company) {
			$out .= '<li>'.$company->name.'</li>';
		}
		$out .= '</ul>';
		$out .= do_shortcode('[state_zip_monet label="marketshare"]');
		$out .= '</div>';

		return $out;
	}

	public static function state_city_bar_graph_shortcode ($atts, $content = null) {
		global $state_data;
		$out = '<div class="city-bar-graph graph">';
		$out .= '<h3>Yearly Rate</h3>';
		$out .= '<ul data-equalizer>';
		foreach ($state_data->company_data as $company) {
			$out .= '<li>';
			$out .= '	<div class="container column-container"><div class="graph column" data-value="'.$company->avg_annual_premium.'" data-max="'.$state_data->max_city_premium.'"><div class="key">$'.number_format($company->avg_annual_premium).'</div></div></div>';
			$out .= '	<div class="name" data-equalizer-watch>'.$company->name.'</div>';
			$out .= '	<div class="logo"><img src="http://assets.reviews.com/images/brand/'.str_replace(' ','',strtolower($company->name)).'.png"></div>';
			$out .= '</li>';
		}
		$out .= '</ul>';
		$out .= do_shortcode('[state_zip_monet label="graph"]');
		$out .= '</div>';
		return $out;
	}

	public static function state_stat_compare_shortcode ($atts, $content = null) {
		global $state_data;
		global $wpdb;
		$statename_qry = $wpdb->prepare('select distinct state_name from city_data where state = "%s"', get_field('state_abbreviation'));
		$state_name = $wpdb->get_results($statename_qry, 'ARRAY_A')[0]['state_name'];
		$addClass = array();

		if (isset($atts['city']) && !empty($atts['city'])) {
			// Sets name to City name
			$addClass[] = 'city';
			$name = $atts['city'].' Auto Insurance';
			$name1 = $atts['city'];
			foreach ($state_data->city_data as $city) {
				if ($city->city == $atts['city']) {
					$population = $city->population;
					$avg_premium_1 = $city->avg_annual_premium;
				}
			}
			$avg_premium_2 = $state_data->avg_annual_premium;
			$avg_premium_max = $state_data->avg_annual_premium * 2;
			// $avg_premium_max = $state_data->max_city_premium;
			$name2 = $state_name;
		} else {
			// Sets name to full state name based on abbreviation
			$name = $state_name;
			$name1 = $state_name;

			// Gets state population
			$population = $state_data->state_population;
			$avg_premium_1 = $state_data->avg_annual_premium;
			$avg_premium_2 = $state_data->average_us;
			$avg_premium_max = $state_data->average_us * 2;
			// $avg_premium_max = $state_data->max_us_premium;
			$name2 = 'US Average';
		}
		if (isset($atts['align'])) {
			$addClass[] = $atts['align'];
		}

		$out = '<div class="stat-compare graph '.implode(' ',$addClass).'">';
		$out .= '	<div class="stat-left">';
		$out .= '		<h2 class="name">'.$name.'</h2>';
		$out .= '		<div class="population">Population: <span>'.number_format($population).'</span></div>';
		$out .= '	</div>';
		$out .= '	<div class="stat-right">';
		$out .= '		<div class="container bar-container"><div class="graph bar white" data-value="'.$avg_premium_1.'" data-max="'.$avg_premium_max.'"><div class="key">'.$name1.'</div></div><div class="key">$'.number_format($avg_premium_1).'</div></div>';
		$out .= '		<div class="container bar-container"><div class="graph bar grey" data-value="'.$avg_premium_2.'" data-max="'.$avg_premium_max.'"><div class="key">'.$name2.'</div></div><div class="key">$'.number_format($avg_premium_2).'</div></div>';
		$out .= '	</div>';
		$out .= '</div>';

		return $out;
	}

	public static function state_zip_monet_shortcode($atts, $content = null) {
		if (isset($atts['align'])) {
			$addclass = ' '.$atts['align'];
		} else {
			$addclass = '';
		}
		if (isset($atts['label'])) {
			$data_label = ' data-label="'.$atts['label'].'"';
		} else {
			$data_label = '';
		}

		$out = '<div class="quote-form'.$addclass.'"'.$data_label.'>';
		if (isset($atts['title'])) {
			$out .= '<h3>'.$atts['title'].'</h3>';
		}
		$out .= '	<form>';
		$out .= '		<input id="zip-code" type="text" class="quote-input" placeholder="ex: 90210">';
		$out .= '		<small id="quote-error" class="error" style="display: none;">Enter Valid Zip Code</small>';
		$out .= '		<input type="submit" class="quote-submit button orange" value="Compare Rates">';
		$out .= '	</form>';
		$out .= '</div>';

		return $out;
	}



}