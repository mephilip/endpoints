<?php

class ReviewsEndpoint extends WP_REST_Controller {

    /**
     * Register the routes for the objects of the controller.
     */
    public function register_routes() {
        $version = '1';
        $namespace = 'reviews/v' . $version;
        $base = 'fetch';
        register_rest_route( $namespace, '/' . $base . '/schema', array(
            'methods'         => WP_REST_Server::READABLE,
            'callback'        => array( $this, 'get_public_item_schema' ),
        ) );
        register_rest_route( $namespace, '/' . $base . '/map', array(
            'methods'         => WP_REST_Server::READABLE,
            'permission_callback' => array( $this, 'get_item_permissions_check' ),
            'callback'        => array( $this, 'get_map_data' ),
            'collection_params'        => array( $this, 'get_collection_params' )
        ) );
        register_rest_route( $namespace, '/' . $base . '/state/(?P<name>.{2,2}+)', array(
            'methods'         => WP_REST_Server::READABLE,
            'permission_callback' => array( $this, 'get_item_permissions_check' ),
            'callback'        => array( $this, 'get_state_data' ),
            'collection_params'        => array( $this, 'get_collection_params' )
        ) );
        register_rest_route( $namespace, '/' . $base . '/email', array(
            'methods'         => WP_REST_Server::READABLE,
            'permission_callback' => array( $this, 'get_item_permissions_check' ),
            'callback'        => array( $this, 'get_email' ),
            'collection_params'        => array( $this, 'get_collection_params' )
        ) );
    }
    
    public function get_email( $request ) {
	    $data = array(
		    'this' => 'test',
		    'that' => 'it_works'
	    );
	    
	    return new WP_REST_Response( $data, 200 );
    }
	
	/**
     * Get a collection of items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|WP_REST_Response
     */
	
	public function get_map_data( $request ) {
        $args = array(
			'post_type'  => 'data',
			'posts_per_page'	=> -1,
			'orderby'    => 'meta_value_num',
			'order'      => 'ASC',
			'meta_query' => array(
				array(
					'key'     => 'data_type',
					'value'   => 'auto_insurance',
					'compare' => 'LIKE',
				)
			)
		);
    	$query = new WP_Query( $args );
		if(!$query->have_posts()){
	        return new WP_Error( '500', __( 'No posts found', 'text-domain' ), 'Null' );
	    }
		$posts = $query->get_posts();
		$posts_count = count($posts);
		$data = array();
		
		// Set to true if value is an ACF
		$fields = array(
					'd3_id' => true, 
					'shortname' => true, 
					'name' => true, 
					'annual_average_premium' => true,  
					'state_min_bi' => true,
					'state_min_per_accident' => true,
					'state_min_pd' => true,
					'ID' => false,
					'quote' => true,
					'quote_name' => true,
					'quote_title' => true,
					'quote_department' => true
				);
		while ($query->have_posts()) : $query->the_post();
			foreach($fields as $key => $value){
				if($value == true){
					$temp[$key] = get_field($key);
				} else {
					$temp[$key] = $query->post->$key;
				}
			}
	    	$data[] = $temp;		    
		endwhile;	   
	  
		
	
        return new WP_REST_Response( $data, 200 );
    }

     /**
     * Check if a given request has access to get items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_items_permissions_check( $request ) {
        return true;
        //return current_user_can( 'edit_something' );
    }

    /**
     * Check if a given request has access to get a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function get_item_permissions_check( $request ) {
        return $this->get_items_permissions_check( $request );
    }

    /**
     * Check if a given request has access to create items
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function create_item_permissions_check( $request ) {
        return current_user_can( 'edit_something' );
    }

    /**
     * Check if a given request has access to update a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function update_item_permissions_check( $request ) {
        return $this->create_item_permissions_check( $request );
    }

    /**
     * Check if a given request has access to delete a specific item
     *
     * @param WP_REST_Request $request Full data about the request.
     * @return WP_Error|bool
     */
    public function delete_item_permissions_check( $request ) {
        return $this->create_item_permissions_check( $request );
    }

    /**
     * Prepare the item for create or update operation
     *
     * @param WP_REST_Request $request Request object
     * @return WP_Error|object $prepared_item
     */
    protected function prepare_item_for_database( $request ) {
        return array();
    }

    /**
     * Prepare the item for the REST response
     *
     * @param mixed $item WordPress representation of the item.
     * @param WP_REST_Request $request Request object.
     * @return mixed
     */
    public function prepare_item_for_response( $item, $request ) {
        return array();
    }

    /**
     * Get the query params for collections
     *
     * @return array
     */
    public function get_collection_params() {
        return array(
            'page'                   => array(
                'description'        => 'Current page of the collection.',
                'type'               => 'integer',
                'default'            => 1,
                'sanitize_callback'  => 'absint',
            ),
            'per_page'               => array(
                'description'        => 'Maximum number of items to be returned in result set.',
                'type'               => 'integer',
                'default'            => 10,
                'sanitize_callback'  => 'absint',
            ),
            'search'                 => array(
                'description'        => 'Limit results to those matching a string.',
                'type'               => 'string',
                'sanitize_callback'  => 'sanitize_text_field',
            ),
        );
    }

    /**
     * Get data for specific state
     *
     * @return WP_REST_Response
     */
    public function get_state_data ( $request ) {
        global $wpdb;
        $params = $request->get_params();
        $state_abbrev = strtolower($params['name']);
        $data = [];

        // US Premium
        $us_premium_qry = '
            select
                round(avg(annual_premium),0) average_us
            from
                auto_data';
        $data['average_us'] = $wpdb->get_results($us_premium_qry, 'ARRAY_A')[0]['average_us'];

        $mi_premium_qry = '
            select 
                round(avg(annual_premium),0) max_us_premium
            from
                auto_data
            where
                lower(state) = "mi"';
        $data['max_us_premium'] = $wpdb->get_results($mi_premium_qry, 'ARRAY_A')[0]['max_us_premium'];

        // Premium per state
        $avg_premium_qry = $wpdb->prepare('
            select
                state,
                max(annual_premium) max_city_premium,
                round(avg(annual_premium),0) as avg_annual_premium
            from
                auto_data
            where
                lower(state) = "%s"
            group by
                state', $state_abbrev);
        $results = $wpdb->get_results($avg_premium_qry, 'ARRAY_A')[0];
        $data['avg_annual_premium'] = $results['avg_annual_premium'];
        $data['max_city_premium'] = $results['max_city_premium'];

        if(empty($data['avg_annual_premium'])){
            return new WP_Error( '500', __( 'No data found', 'text-domain' ), 'Null' );
        }

        // Population in state
        $state_pop_qry = $wpdb->prepare('
        select
            state_name,
            population
        from
            state_data
        where
            lower(state) = "%s"', $state_abbrev);
        $results =  $wpdb->get_results($state_pop_qry, 'ARRAY_A')[0];
        $data['state_population'] = $results['population'];
        $data['state_name'] = $results['state_name'];


        // Minimum coverages
        $min_coverages_qry = $wpdb->prepare('
            select
                bi_limit,
                pd_limit
            from
                auto_data
            where
                coverage_set = "State Minimum BI/PD" and
                lower(state) = "%s"
            group by
                state', $state_abbrev);
        $results = $wpdb->get_results($min_coverages_qry, 'ARRAY_A');
        $results = $results[0];
        $bi_limit = explode('/', $results['bi_limit']);
        $data['bi_per_person'] = $bi_limit[0];
        $data['bi_per_accident'] = $bi_limit[1];
        if ($results['pd_limit'] > 1000) {
            $results['pd_limit'] = floor($results['pd_limit'] / 1000);
        }
        $data['pd_limit'] = $results['pd_limit'];

            
        // Company data per state
        $company_qry = $wpdb->prepare('
            select
                quadrant_company_group as name,
                round(avg(annual_premium),0) as avg_annual_premium
            from
                auto_data
            where
                lower(state) = "%s"
            group by
                quadrant_company_group
            order by
                company_state_rank', $state_abbrev);
        $data['company_data'] = $wpdb->get_results($company_qry, 'ARRAY_A');

        // Premiums per by city
        $city_premium_qry = $wpdb->prepare('
        select
            city,
            population,
            round(avg(annual_premium),0) as avg_annual_premium
        from
            auto_data
        left join
            city_data
        using
            (state, city)
        where
            lower(state) = "%s"
        group by
            city
        order by
            avg_annual_premium asc', $state_abbrev);
        $data['city_data'] = $wpdb->get_results($city_premium_qry, 'ARRAY_A');

        return new WP_REST_Response( $data, 200 );
    }
}