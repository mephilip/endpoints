<div class="methodology">
	<h2><?php the_sub_field('title'); ?></h2>
	<?php if (get_sub_field('methodology_compare')) { ?>
		<div class="stats">
		<?php $compare = get_sub_field('methodology_compare');
		foreach ($compare as $c) { ?>
			<div class="stat">
				<div class="text pre-number-text"><?php echo $c['pre_number_text'] ?></div>
				<div class="number">
					<?php echo $c['number'] ?>
					<?php if ($c['icon']) { ?>
					<img class="icon" src="<?php echo $c['icon']; ?>" />
					<?php } ?>
				</div>
				<div class="text"><?php echo $c['text'] ?></div>
			</div>	
		<?php	} ?>
		</div>
	<?php } ?>
	<div class="popdown">
		<?php the_sub_field('text'); ?>
	</div>
</div>
