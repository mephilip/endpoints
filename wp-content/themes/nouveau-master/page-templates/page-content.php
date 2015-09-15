<?php
/**
 * Template Name: Old Content Only
 */

\NV\Theme::get_header('special');
\NV\Theme::output_file_marker( __FILE__ );
?>

  <div class="container">
      <?php
      // Calls function to process flexible content
      \NV\Custom\Functions::process_content('flexible');
      ?>
  </div>
<?php
\NV\Theme::get_footer('special');