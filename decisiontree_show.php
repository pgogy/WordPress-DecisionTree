<?PHP

add_action("the_content", "decisiontree_display" );
add_action("wp_head","decisiontree_display_javascript");
	
function decisiontree_display_javascript(){

	global $post;

	if($post->post_type=="decisiontree"){
	
		wp_enqueue_script( "decisiontree_display", plugins_url() . "/decisiontree/scripts/decisiontree_display.js",	array( 'jquery' ));
		wp_register_style( 'custom_wp_show_css', plugins_url() . '/decisiontree/css/show.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_show_css' );
		
	}
				
}

function decisiontree_display($content)
{

	global $post;

	if($post->post_type=="decisiontree"){
	
		$wp_dir = wp_upload_dir();
	
		$data = stripslashes(file_get_contents($wp_dir['basedir'] . "/decisiontree/" . $post->ID . ".inc"));
		
		$data = json_decode($data, true);
	
		$counter = 0;

		$library = $data;

		echo "<div class='library'>";

		while($choice = array_shift($library)){
			
			echo "<div id='" . $choice['id'] . "'>";
			echo "<p style='background:#" . $choice['colour'] . "'>" . $choice['html'] . "</p>";
			
			echo "<div>";
			
			while($option = array_shift($choice['choices'])){
			
				echo "<span onclick='javascript:show_choice(" . $option[1] . "," . $choice['id'] . ", this);'>" . $option[0] . "</span>";
			
			}
			
			echo "</div>";
			echo "</div>";

		}

		echo "</div>";

		$choice = array_shift($data);

		echo "<div class='choice'>";
		echo "<div id='" . $choice['id'] . "'>";
		echo "<p>" . $choice['html'] . "</p>";

		echo "<div>";

		while($option = array_shift($choice['choices'])){

			echo "<span onclick='javascript:show_choice(" . $option[1] . "," . $choice['id'] . ", this);'>" . $option[0] . "</span>";

		}

		echo "</div>";

		echo "</div>";

					
	}
	
}

?>