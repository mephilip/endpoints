<?php
	
	global $post;

	$post_id = $post->ID;
	if( have_rows('updates',$post_id) ): 
    $rows = get_field('updates');
    $row_count = count($rows);
    $update_count = 1;
    ?>
    <div id="updates">
        <?php

        while( have_rows('updates',$post_id) ): the_row();

            $date = DateTime::createFromFormat('Ymd', get_sub_field('date'));
            $update = get_sub_field('update');

            if($update_count  == 1){
                echo "<div id='first-update'>";
                echo "<h6>Latest Update: " . $date->format('M d, Y') . "</h6>";
                echo "$update";
                echo "</div>";
            } else {
                if($update_count == 2){
                    echo "<div class='update-open text-center'>";
                    echo "<div class='recent'>Most Recent Updates</div>";
                    echo "<div class='drop-down'><i class='icon-down-open-big'></i></div>";
                    echo "</div>";
                    echo "<div class='update-reveal'>";
                }

                echo "<p><span class='date'>".$date->format('M d, Y')." - </span> <span class='update'>$update</span></p>";

                if($update_count >= $row_count){
                    echo "</div>";
                }

            }

            $update_count++;
        endwhile;
        ?>
    </div>
	<?php endif; 
