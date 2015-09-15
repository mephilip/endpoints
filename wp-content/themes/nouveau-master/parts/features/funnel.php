
<div id="funnelContainer"></div>

<div class="section offset text-block" id="funnelReveal">
	<div id="reveal-text">

		<?php if( have_rows('funnel_data') ): ?>


		<?php 
		while( have_rows('funnel_data') ): the_row();
			$funnel_content = get_sub_field('funnel_content');
			$funnel_text = get_sub_field('funnel_text');
			$funnel_id = str_replace(' ', '_', $funnel_text);
		 
		 ?>
		 	<div class="funnel-reveal" id="<?php echo $funnel_id;?>">
			 	<?php echo $funnel_content;?>
		 	</div>
		 
		 <?php 
		
			 
			 
		 endwhile; ?>
		
		<?php endif; ?>
		
	</div>
</div>


<?php 
	$rows = get_sub_field('funnel_data');
	$row_count = count($rows);
	$count = 0;
?>

<?php if( have_rows('funnel_data') ): ?>

<script>
var funnelData = [
<?php 
while( have_rows('funnel_data') ): the_row();
	$funnel_text = get_sub_field('funnel_text');
	$funnel_number = get_sub_field('funnel_number');
	$funnel_content = get_sub_field('funnel_content');
	
	$funnel_id = str_replace(' ', '_', $funnel_text);
 
 ?>
 ["<?php echo $funnel_text;?>",<?php echo $funnel_number;?> ],
 
 <?php 

	 
	 
 endwhile; ?>
]
</script>
<?php endif; ?>


