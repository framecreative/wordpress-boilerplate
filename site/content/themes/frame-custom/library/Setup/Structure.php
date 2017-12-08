<?php

namespace Frame\Setup;

use \Frame\Helpers;

class Structure
{

	function setup()
	{


		add_action('init', [ $this, 'register_site_options' ]);
		add_action('init', [ $this, 'register_taxonomies' ]);
		add_action('init', [ $this, 'register_post_types' ]);
		add_action('init', [ $this, 'register_menus' ]);

		add_filter('theme_page_templates', [ $this, 'register_page_templates' ]);
		add_filter( 'Timber\PostClassMap', array( $this, 'map_post_classes' ) );

	}

	public function map_post_classes() {

		/*
		 * Map custom models to post types

		return [
			'page' => 'Frame\Models\Page'
		];

		*/

	}

	public function register_page_templates( $templates ) {

		/*
		 * Add custom page templates

		$templates['test'] = 'Test Template';

		*/

		return $templates;

	}

	public function register_post_types()
	{

		/*

		*** Remove Editor from pages ***

		remove_post_type_support( 'page', 'editor' );

		*/

		/*

        *** Register Custom Post Type ***

		register_post_type(
			'design',
			[
				'public'             	=> true,
				'capability_type'    	=> 'post',
				'hierarchical'       	=> false,
				'exclude_from_search' 	=> false,
				'supports'           	=> [ 'title' ],
				'menu_position'      	=> '20.1',
				'rewrite'            	=> [ 'slug' => 'home-designs' ],
				'menu_icon'          	=> Helpers\Admin::custom_icon('assets/admin/design.svg'),
				'has_archive'        	=> true,
				'labels'             	=> [
					'name'               	=> 'Designs',
					'singular_name'      	=> 'Design',
					'menu_name'          	=> 'Designs',
					'name_admin_bar'     	=> 'Design',
					'add_new'            	=> 'Add New',
					'add_new_item'       	=> 'Add New Design',
					'new_item'           	=> 'New Design',
					'edit_item'          	=> 'Edit Design',
					'view_item'          	=> 'View Design',
					'all_items'          	=> 'All Designs',
					'search_items'       	=> 'Search Designs',
					'parent_item_colon'  	=> 'Parent Designs:',
					'not_found'          	=> 'No Designs found.',
					'not_found_in_trash' 	=> 'No Designs found in Trash.'
				]
			]
		);

		*/

	}

	public function register_taxonomies()
	{

		/*

        *** Register Custom Taxonomy ***

		register_taxonomy(
			'range',
			[ 'design' ],
			[
				'label' => 'Range',
				'public' => true,
				'rewrite' => [
					'slug' => 'home-designs/range'
				],
				'hierarchical' => false,
				'show_admin_column' => true,
				'meta_box_cb' => false,
				'show_tagcloud' => false,
				'labels' => [
					'name' => 'Ranges',
					'singular_name' => 'Range',
					'search_items' => null,
					'popular_items' => null,
					'add_new_item' => 'Add New Range',
					'edit_item' => 'Edit Range'
				]
			]
		);

		*/

	}



	public function register_menus()
	{

		/*

        *** Register Navigation Menu ***

		register_nav_menus(
			[
				'main-menu' => 'Main Menu'
			]
		);

		*/

	}

	public function register_site_options()
	{

		if ( function_exists('acf_add_options_page') ) {

			acf_add_options_page([
				'page_title' => 'Site Options',
				'menu_slug' => 'site-options',
				'position' => '30.9',
				'icon_url' => Helpers\Admin::custom_icon('admin/icons/settings.svg')
			]);

		}

	}

}