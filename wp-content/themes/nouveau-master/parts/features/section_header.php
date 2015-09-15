<?php if (get_sub_field('offset')) { $offset = 'offset'; } else { $offset = ''; } ?>
<?php if (get_sub_field('url_link')) { ?>
	<div class="section-header <?php echo $offset; ?>" data-magellan-destination="<?php the_sub_field('url_link'); ?>">
	<a name="<?php the_sub_field('url_link'); ?>"></a>
<?php } else { ?>
	<div class="section-header <?php echo $offset; ?>">
<?php } ?>
	<?php if (get_sub_field('pre_header_text')) { ?>
		<h5><?php the_sub_field('pre_header_text'); ?></h5>
	<?php } ?>
	<?php if (get_sub_field('header_text')) { ?>
		<h2><?php the_sub_field('header_text'); ?></h2>
	<?php } ?>
</div>
