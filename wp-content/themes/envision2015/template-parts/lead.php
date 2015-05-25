<?php global $post; ?>
<div class="outer container">
	<?php 
		$lead = get_field('lead_content');
		if(isset($lead) && !empty($lead)){
			echo '<div class="lead">'.$lead.'</div>';
		} 
	?>
</div>