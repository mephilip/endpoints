<div class="finalists">
	<?php $finalists = get_sub_field('list'); ?>
	<div class="list">
		<?php foreach ($finalists as $finalist) { ?>
		<div class="finalist">
			<img class="logo" src="<?php echo $finalist['company_logo']; ?>">
			<div class="name"><a href="<?php echo get_bloginfo('wpurl').'/'.$finalist['url'].'/' ?>"><?php echo $finalist['text']; ?></a></div>
		</div>
		<?php } ?>		
	</div>
</div>
