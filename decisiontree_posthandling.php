<?PHP

add_action("save_post", "decisiontree_create");
add_action("before_delete_post", "decisiontree_delete"); 

function decisiontree_create($post_id)
{

	$data = get_post($post_id);
	
	$wp_dir = wp_upload_dir();
	
	if($data->post_type=="decisiontree"){

		if(!empty($_POST)){

			if (!wp_verify_nonce($_POST['decisiontree_save_field'],'decisiontree_save') ){
			   print 'Sorry, your nonce did not verify.';
			   exit;
			}

		}
					
		if(isset($_POST)){
			
			file_put_contents($wp_dir['basedir'] . "/decisiontree/" . $post_id . ".inc", $_POST['data_save']);
			
		}
	
	}

}


function decisiontree_delete($post_id){

	$data = get_post($post_id);
	
	if($data->post_type=="decisiontree"){

		$wp_dir = wp_upload_dir();
	
	
	}

}

?>