<?php
// Load the NV library
require_once 'nv/NV.php';

// Initialize the NV library (also returns requirements check)
if ( NV::init() ) {
    // ADD OTHER CODE HERE

}

function new_rest_routes() {

	foreach ( get_post_types( array( 'show_in_rest' => true ), 'objects' ) as $post_type ) {
		$class = ! empty( $post_type->rest_controller_class ) ? $post_type->rest_controller_class : 'WP_REST_Posts_Controller';

		if ( ! class_exists( $class ) ) {
			continue;
		}
		
		$controller = new ReviewsEndpoint();
		$controller->register_routes();


		if ( post_type_supports( $post_type->name, 'custom-fields' ) ) {
			$meta_controller = new WP_REST_Meta_Posts_Controller( $post_type->name );
			$meta_controller->register_routes();
		}
		if ( post_type_supports( $post_type->name, 'revisions' ) ) {
			$revisions_controller = new WP_REST_Revisions_Controller( $post_type->name );
			$revisions_controller->register_routes();
		}

		foreach ( get_object_taxonomies( $post_type->name, 'objects' ) as $taxonomy ) {

			if ( empty( $taxonomy->show_in_rest ) ) {
				continue;
			}

			$posts_terms_controller = new WP_REST_Posts_Terms_Controller( $post_type->name, $taxonomy->name );
			$posts_terms_controller->register_routes();
		}
	}

	/*
	 * Post types
	 */
	$controller = new WP_REST_Post_Types_Controller;
	$controller->register_routes();

	/*
	 * Post statuses
	 */
	$controller = new WP_REST_Post_Statuses_Controller;
	$controller->register_routes();

	/*
	 * Taxonomies
	 */
	$controller = new WP_REST_Taxonomies_Controller;
	$controller->register_routes();

	/*
	 * Terms
	 */
	foreach ( get_taxonomies( array( 'show_in_rest' => true ), 'object' ) as $taxonomy ) {
		$class = ! empty( $taxonomy->rest_controller_class ) ? $taxonomy->rest_controller_class : 'WP_REST_Terms_Controller';

		if ( ! class_exists( $class ) ) {
			continue;
		}
		$controller = new $class( $taxonomy->name );
		if ( ! is_subclass_of( $controller, 'WP_REST_Controller' ) ) {
			continue;
		}

		$controller->register_routes();
	}

	/*
	 * Users
	 */
	$controller = new WP_REST_Users_Controller;
	$controller->register_routes();

	/**
	 * Comments
	 */
	$controller = new WP_REST_Comments_Controller;
	$controller->register_routes();

}
add_action( 'rest_api_init', 'new_rest_routes', 0 );

 
// Temporary Functions ~ Will build into the core
add_action( 'init', 'create_post_type' );
function create_post_type() {

    $labels = array(
        'name'               => _x( 'Data', 'post type general name', '' ),
        'singular_name'      => _x( 'Item', 'post type singular name', '' ),
        'menu_name'          => _x( 'Data', 'admin menu', '' ),
        'name_admin_bar'     => _x( 'Item', 'add new on admin bar', '' ),
        'add_new'            => _x( 'Add New', 'Item', '' ),
        'add_new_item'       => __( 'Add New Item', '' ),
        'new_item'           => __( 'New Item', '' ),
        'edit_item'          => __( 'Edit Item', '' ),
        'view_item'          => __( 'View Item', '' ),
        'all_items'          => __( 'All Items', '' ),
        'search_items'       => __( 'Search Items', '' ),
        'parent_item_colon'  => __( 'Parent Item:', '' ),
        'not_found'          => __( 'No Items found.', '' ),
        'not_found_in_trash' => __( 'No Items found in Trash.', '' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'exclude_from_search'=> true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'item' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'show_in_rest'		 => true,
        'supports'           => array( 'title')
    );
    register_post_type( 'data', $args );
}

