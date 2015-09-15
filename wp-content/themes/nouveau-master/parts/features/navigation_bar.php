<div class="navigation-bar" data-magellan-expedition="fixed">
	<ul class="sub-nav">
		<?php $menu_items = get_field('navigation_bar'); ?>
		<?php foreach ($menu_items as $mi) { ?>
			<li data-magellan-arrival="<?php echo $mi['id_link'] ?>"><a href="#<?php echo $mi['id_link'] ?>"><?php echo $mi['text'] ?></a></li>
		<?php } ?>
	</ul>
</div>
