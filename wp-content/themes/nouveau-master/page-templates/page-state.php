<?php
/**
 * Template Name: State Page
 */
\NV\Theme::get_header();
\NV\Theme::output_file_marker( __FILE__ );

if (empty($state_data)) {
  if (strpos(get_site_url(),'http://54.152.109.187/') > -1) {
    $siteurl = str_replace('54.152.109.187', 'soda:soda@54.152.109.187', get_site_url());
  } else {
    $siteurl = get_site_url();
  }
  $state_data = json_decode(file_get_contents($siteurl.'/wp-json/reviews/v1/fetch/state/'.strtolower(get_field('state_abbreviation'))));
}

?>
  <div class="state-abbrev" data-stateabbrev="<?php echo strtolower(get_field('state_abbreviation')); ?>"></div>
  <div id="container">
    <div id="header">
      <div class="header-content">
        <h1 class="category-title"><?php echo the_field('category_title'); ?></h1>
        <div class="title"><?php echo the_field('main_title'); ?></div>
        <div class="subtitle"><?php echo the_field('subtitle'); ?></div>
      </div>
      <?php get_template_part ('/parts/features/navigation_bar') ?>
    </div>
    <div id="content">
	  <?php get_template_part ('/parts/modules/updates') ?>

      <?php
      // Calls function to process flexible content
      \NV\Custom\Functions::process_content('flexible');
      ?>
    </div>

    <div id="footer" class="columns">
      <div id="modal" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" role="dialog">
        <div id="modal-results"></div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
      </div>
    </div>

  </div>
<?php
\NV\Theme::get_footer();