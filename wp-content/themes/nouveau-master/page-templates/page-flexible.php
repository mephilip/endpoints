<?php
/**
 * Template Name: Flexible Content
 */
\NV\Theme::get_header();
\NV\Theme::output_file_marker( __FILE__ );
?>

  <div id="container">
    <div id="header">
      <div class="header-content">
        <h1 class="category-title"><?php echo the_field('category_title'); ?></h1>
        <div class="title"><?php echo the_field('main_title'); ?></div>
        <div class="subtitle"><?php echo the_field('subtitle'); ?></div>
        <div class="cta header-cta">
          <div class="button orange">
            <a href="http://www.reviews.com/auto-insurance/quotes/">Compare Rates</a>
          </div>
        </div>
      </div>
      <?php get_template_part ('/parts/features/navigation_bar') ?>
    </div>
    <div id="content">
	   <?php get_template_part ('/parts/modules/updates') ?>

      <?php
      // Instantiates new class for Custom Functions
      // $functions = new \NV\Custom\Functions;

      // Calls function to process flexible content
      // $functions->process_flexible_content();
      \NV\Custom\Functions::process_content('flexible');
      ?>
    </div>

    <div id="footer" class="columns">

    </div>

  </div>
<?php
\NV\Theme::get_footer();