<div class="stat-highlight">
	<?php 
		$highlights = get_sub_field('highlights');
		foreach ($highlights as $highlight) { ?>
			<div class="highlight">
				<p class="stat"><?php echo $highlight['stat']; ?></p>
				<p><?php echo $highlight['stat_blurb']; ?></p>
			</div>
	<?php
		}
	 ?>	
	<div class="source">
		<?php echo get_sub_field('source'); ?>
	</div>
</div>