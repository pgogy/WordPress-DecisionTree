<?PHP

class decisiontree_show{

	function __construct(){
		add_action("the_content", array($this, "decisiontree_display") );
		add_action("wp_head", array($this,"decisiontree_display_javascript") );
	}
	
	function decisiontree_display_javascript(){

		global $post;

		if($post->post_type=="decisiontree"){
		
			wp_enqueue_script( "decisiontree_display", plugins_url() . "/decision-tree/scripts/decisiontree_display.js",	array( 'jquery' ));
			wp_register_style( 'custom_wp_show_css', plugins_url() . '/decision-tree/css/show.css', false, '1.0.0' );
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
				
				if(isset($choice['colour'])){
					$colour = $choice['colour'];
				}else{
					$colour = "#fff";
				}
				
				echo "<div id='" . $choice['id'] . "'>";
				echo "<p style='background:#" . $colour . "'>" . $choice['html'] . "</p>";
				
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

}

$decisiontree_show = new decisiontree_show;

?>