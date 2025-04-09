<?php

/**
 * Plugin requirements (TGMPA) & Bootstrap CMB2
 */
//require_once get_template_directory_uri() . 'inc/class-tgm-plugin-activation.php';

/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
~~~~PROPER WAY OF ADDING CHILD THEME CSS FILE ~~~~
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	
	/* qTip CSS */
	//wp_enqueue_style('twentytwenty-css', get_stylesheet_directory_uri() . '/css/twentytwenty.css', null, false, false);
	
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

/**
* Proper way to enqueue JS 
*/
function pegasus_child_bootstrap_js() {
	
	wp_enqueue_script( 'pegasus_child_custom_js', get_stylesheet_directory_uri() . '/js/pegasus-custom.js', array(), '', true );
	
	//wp_enqueue_script( 'matchHeight_js', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array(), '', true );
	
	
} //end function
add_action( 'wp_enqueue_scripts', 'pegasus_child_bootstrap_js' );



function create_technique_post_type() {

    $technique_labels = array(
        'name' => 'Happomoku',
        'singular_name' => 'Happomoku',
    );

    $technique_args = array(
        'labels' => $technique_labels,
        'public' => true,
        'show_in_rest' => true,
        'rest_base' => 'techniques',
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 6,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'custom-fields')
    );

    register_post_type('technique', $technique_args);

    $levels_labels = array(
        'name' => 'Levels',
        'singular_name' => 'Level',
        'search_items' => 'Search Levels',
        'all_items' => 'All Levels',
        'parent_item' => 'Parent Level',
        'parent_item_colon' => 'Parent Level',
        'edit_item' => 'Edit Level',
        'update_item' => 'Update Level',
        'add_new_item' => 'Add New Level',
        'new_item_name' => 'New Level Name',
    );

    $styles_labels = array(
        'name' => 'Styles',
        'singular_name' => 'Style',
        'search_items' => 'Search Styles',
        'all_items' => 'All Styles',
        'parent_item' => 'Parent Style',
        'parent_item_colon' => 'Parent Style',
        'edit_item' => 'Edit Style',
        'update_item' => 'Update Style',
        'add_new_item' => 'Add New Style',
        'new_item_name' => 'New Style Name',
    );

    register_taxonomy('technique_level', array('technique'), array(
        'hierarchical' => true,
        'labels' => $levels_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'technique-level'),
    ));

    register_taxonomy('technique_style', array('technique'), array(
        'hierarchical' => false,
        'labels' => $styles_labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'technique-style'),
    ));
}

add_action('init', 'create_technique_post_type');
// Hook the function to the 'init' action to register the post type

/**
 * Hook in and add a metabox for the Technique post type
 */
add_action('cmb2_admin_init', 'add_technique_metabox');

function add_technique_metabox()
{
    /**
     * Create a new metabox for the 'technique' post type
     */
    $cmb = new_cmb2_box(array(
        'id'            => 'technique_metabox', // Unique ID for the metabox
        'title'         => __('Technique Details', 'your-text-domain'), // Title of the metabox
        'object_types' => array('technique'), // Post type where the metabox should appear
        'context'       => 'normal', // Where the metabox should display (normal, side, advanced)
        'priority'      => 'high', // Priority of the metabox (high, core, default, low)
        'show_names'    => true, // Show field names on the left
    ));

    /**
     * Add a 'Belt Level' field (select dropdown)
     */
    $cmb->add_field(array(
        'name'    => __('Belt Level', 'your-text-domain'),
        'desc'    => __('Select the appropriate belt level for this technique', 'your-text-domain'),
        'id'      => 'technique_belt_level', // Unique ID for the field
        'type'    => 'select',
        'options' => array( 
            'white'  => __('White', 'your-text-domain'),
            'yellow' => __('Yellow', 'your-text-domain'),
            'green'  => __('Green', 'your-text-domain'),
            'brown'  => __('Brown', 'your-text-domain'),
            'black'  => __('Black', 'your-text-domain'),
        ),
        'default' => 'white', // Default value (optional)
    ));

    // Add other custom fields here in the future, using $cmb->add_field()

}

?>