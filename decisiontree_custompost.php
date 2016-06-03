<?PHP

class decisiontree_custompost{

	function __construct(){	

		add_action('init', array($this,'decisiontree_custom_page_type_create'));
	
	}

	function decisiontree_custom_page_type_create() 
	{
	  $labels = array(
		'name' => _x('Decision Trees', 'post type general name'),
		'singular_name' => _x('Decision Tree', 'post type singular name'),
		'add_new' => _x('Add New', 'decisiontree'),
		'add_item' => __('Add New '),
		'edit_item' => __('Edit Decision Tree'),
		'item' => __('New Decision Tree'),
		'view_item' => __('View Decision Tree'),
		'search_items' => __('Search Decision Tree'),
		'not_found' =>  __('No Decision Trees found'),
		'not_found_in_trash' => __(	'No Decision Trees found in Trash'), 
		'parent_item_colon' => '',
		'menu_name' => 'Decision Tree'

	  );
	  
	  $args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'menu_item' => plugin_dir_url(__FILE__) . "logo.jpg",
		'_edit_link' => 'post.php?post=%d',	
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => null,
		'rewrite' => false,
		'description' => 'A Collection of terms which which to search for resources with',
		'supports' => array('title'),
		'taxonomies' => array('category', 'post_tag')
	  ); 
	  register_post_type('decisiontree',$args);

	}
	
}

$decisiontree_custompost = new decisiontree_custompost;

?>