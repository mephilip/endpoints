<div class="other_list <?php the_sub_field('background_color'); ?>">
	<h2><?php the_sub_field('title'); ?></h2>
	<?php if (get_sub_field('list_items')) { ?>
		<ul>
		<?php $items = get_sub_field('list_items');
		foreach ($items as $item) { ?>
		<li>
			<div class="header"><?php echo $item['list_item_header']; ?></div>
			<div class="content"><?php echo $item['list_item_content'] ?></div>
		</li>
		<?php	} ?>
		</ul>
	<?php } ?>
</div>
