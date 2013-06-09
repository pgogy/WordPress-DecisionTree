<?PHP

	/*
	Plugin Name: Decision Tree
	Description: Displays a decision tree on a WordPress Site
	Version: 0.1
	Author: pgogy
	Author URI: http://www.pgogy.com
	*/

	require_once("decisiontree_editor.php");
	require_once("decisiontree_show.php");
	require_once("decisiontree_custompost.php");
	require_once("decisiontree_posthandling.php");
	
	register_activation_hook( __FILE__, 'decisiontree_activate' );
	
	register_deactivation_hook( __FILE__ , 'simile_timeline_deactivate');
	
	function decisiontree_activate(){
				
		$wp_dir = wp_upload_dir();
		
		if(!file_exists($wp_dir['basedir'] . "/decisiontree/")){
		
			mkdir($wp_dir['basedir'] . "/decisiontree/");
			chmod($wp_dir['basedir'] . "/decisiontree/",0755);
			
		}
		
	
	}
	
	function decisiontree_deactivate(){
		
	}

?>