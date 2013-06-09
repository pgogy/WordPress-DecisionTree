<?PHP

add_action("admin_menu", "decisiontree_editor_make");
add_action("admin_enqueue_scripts", "decisiontree_scripts");
add_action("init", "decisiontree_scripts");

function decisiontree_scripts(){

	if(is_admin()){
		wp_enqueue_script( "decisiontree_control", plugins_url() . "/decisiontree/scripts/decisiontree_control.js");
	}
	wp_enqueue_script( "decisiontree_json", plugins_url() . "/decisiontree/scripts/json-2.js");
	wp_enqueue_script( "decisiontree_jscolor", plugins_url() . "/decisiontree/scripts/jscolor/jscolor.js");
	wp_register_style( 'custom_wp_admin_css', plugins_url() . '/decisiontree/css/admin.css', false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
	return;

}

function decisiontree_editor_make()
{

	add_meta_box("decisiontree_edit_desc", "Decision Tree Editor", "decisiontree_edit_desc", "decisiontree");
	
}

function decisiontree_edit_desc(){

	global $post;
	
	$wp_dir = wp_upload_dir();

	wp_nonce_field('decisiontree_save','decisiontree_save_field');
	
	if($_GET['post']!=""){
	
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' =>'image',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
		);
		$query_images = new WP_Query( $args );
		$images = array();
		foreach ( $query_images->posts as $image) {
			$images[]= $image->guid;
		}

		$images = array_unique($images);
		
		echo "<div class='dataholder'>";
		
		if(count($images)!=0){
			
			echo '<span class="expand" onclick="javascript:expand_choice(this)">+</span>';
			echo "<h2>Add an image</h2>";
			echo "<div class='hide'>";
			
			echo "<p>Click on an image to get the HTML</p>";
		
			foreach($images as $image){
			
				echo " <img class='decisiontreeimage' alt='" . $image->post_title . "' title='" . $image->post_title . "' onclick='javascript:add_img_html(this);' src='" . $image . "' /> ";
			
			}
			
			echo "<textarea id='imghtml'></textarea>";
			
			echo "</div>";
			
		}
		
		echo "</div>";
		
		$args = array(
			'post_type' => 'post',
			'numberposts' => 99,
		);
		$query_posts = new WP_Query( $args );
		$posts = array();
		foreach ( $query_posts->posts as $post) {
			$posts[]= array($post->post_title, $post->guid);
		}

		$posts = array_unique($posts);
		
		echo "<div class='dataholder'>";
		
		if(count($posts)!=0){
			
			echo '<span class="expand" onclick="javascript:expand_choice(this)">+</span>';
			echo "<h2>Add a post</h2>";
			echo "<div class='hide'>";	
			
			echo "<p>Click on a post to gain the HTML required</p>";
		
			foreach($posts as $post){
			
				echo "<p><a href='" . $post[1] . "'>" . $post[0] . "</a> - <span onclick='javascript:add_link_html(this);'>Click here to get HTML</span></p>";
			
			}
			
				echo "<textarea id='posthtml'></textarea>";
			
			echo "</div>";
			
		}
		
		echo "</div>";
	
		$data = json_decode(stripslashes(file_get_contents($wp_dir['basedir'] . "/decisiontree/" . $_GET['post'] . ".inc")));
	
		?>
		<div id="decisions">
			<?PHP
			
				if($data!=""){
				
					foreach($data as $index => $choice){
					
						?>
						<div class="prompt" id="<?PHP echo $choice->id; ?>">
							<span class="expand" onclick="javascript:expand_choice(this)">+</span>
							<p class="title" onclick="javascript:edit_title(this)"><?PHP echo $choice->name; ?></p>
							<form class="hide">	
								<input type="text" value="" /><a onclick="javascript:save_text(this)">Change</a>
							</form>
							<div>
								<p>Text to appear for this choice</p>
								<textarea><?PHP echo $choice->html; ?></textarea>
								<p>
									Colour <input class="color" type="text" value="<?PHP echo $choice->colour; ?>" />
								</p>
							</div>			
							<div>
								<h2>Options</h2>
								<div class="choices_menu">
									<p onclick="javascript:edit_title(this)">Click to add an option</p>
									<form class="hide">
										<input type="text" value="New option" /><a onclick="javascript:save_option(this)">Add</a>
									</form>
									<div class="choices"><?PHP
									
										$total = count($choice->choices);
									
										while($option = array_shift($choice->choices)){
										
											?><div>
												<div class="option">
													<span onclick="javascript:left_choice(this)"><</span>
													<p onclick="javascript:edit_option_title(this)"><?PHP echo $option[0]; ?></p>
													<span onclick="javascript:right_choice(this)">></span>
													<span onclick="javascript:delete_choice(this)">X</span>
												</div>
												<form class="option_form hide">
													<input type="text" value="" />
													<select class="route"><?PHP
													
														if($total!=1){
														
															echo "<option value='null'>Choose</option>";
															
															foreach($data as $optindex => $optvalue){
															
																echo "<option value='" . $optindex . "' "; 
																if($option[1]==$optindex){
																	echo " selected ";
																}
																echo ">" . $optindex . ". " . $option[0] . "</option>";
															
															}
														
														}
													
													?></select>
													<a onclick="javascript:save_route_choice(this)">Change</a>
												</form>
											</div><?PHP
										
										}
									
									?></div>
								</div>
							</div>
							<p class="delete"><span onclick="javascript:delete_prompt(this)">Delete</span><span onclick="javascript:move_up(this)">Move Up</span><span onclick="javascript:move_down(this)">Move Down</span></p>
						</div>
						<?PHP
						
					}
				
				}else{
			
				}
				
			?>
		</div>
		<p class="decision"><a onclick="javascript:add_decision();">Add Decision</a></p>
		<input id="data_save" name="data_save" type="hidden" value="" />
		<?PHP
		
	}else{
	
		?>
		<div id="decisions">
			<div class="prompt" id="0">
				<span class="expand" onclick="javascript:expand_choice(this)">+</span>
				<p class="title" onclick="javascript:edit_title(this)">Choice</p>
				<form class="hide">
					<input type="text" value="" /><a onclick="javascript:save_text(this)">Change</a>
				</form>
				<div>
					<p>Text to appear for this choice</p>
					<textarea></textarea>
					<p>
						Colour <input class="color" type="text" value="#ffffff" />
					</p>
				</div>			
				<div>
					<h2>Options</h2>
					<div class="choices_menu">
						<p onclick="javascript:edit_title(this)">Click to add an option</p>
						<form class="hide">
							<input type="text" value="New option" /><a onclick="javascript:save_option(this)">Add</a>
						</form>
						<div class="choices">
						</div>
					</div>
				</div>
				<p class="delete"><span onclick="javascript:delete_prompt(this)">Delete</span><span onclick="javascript:move_up(this)">Move Up</span><span onclick="javascript:move_down(this)">Move Down</span></p>
			</div>
		</div>
		<p class="decision"><a onclick="javascript:add_decision();">Add Decision</a></p>
		<input id="data_save" name="data_save" type="hidden" value="" />
		<?PHP
	
	}
	
	
}	
?>