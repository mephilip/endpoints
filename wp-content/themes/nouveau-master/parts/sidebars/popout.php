<?php 
	if (get_sub_field('anchor')) { 
		$anchor = 'id="'.get_sub_field('anchor').'"';
	} else {
		$anchor = '';
	} ?>
<div class="pop-out" <?php echo $anchor ?>>
	<div class="close-out">
		<i class="fa fa-times"></i>
	</div>
	<h3><?php the_sub_field('pre_title'); ?></h3>
	<h2><?php the_sub_field('title'); ?></h2>
	<div class="visible-content"><?php the_sub_field('blurb'); ?></div>
	<?php if (get_sub_field('read_more_content')) { ?>
		<div class="read-more">
			<div class="read">Read More</div>
			<div class="arrow"><i class="icon-down-open-big"></i></div>
		</div>
		<div class="hidden-content">
			<?php the_sub_field('read_more_content'); ?>
		</div>
	<?php } ?>
</div>