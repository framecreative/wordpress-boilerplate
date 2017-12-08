<?php

namespace Frame\Setup;

use Twig_SimpleFilter;
use Frame\Models\Site;
use Frame\Helpers\Assets;

class Frontend {

	function __construct()
	{

		$this->assets = new Assets();

	}

	function setup()
	{

		add_filter('timber_context', [ $this, 'add_to_context' ]);
		add_filter('timber/loader/twig', [ $this, 'add_to_twig' ]);

		add_action('wp_enqueue_scripts', [ $this, 'enqueue_scripts' ]);

		// Remove WP Admin bar ***
		// add_filter('show_admin_bar', '__return_false');

	}

	public function add_to_context( $context )
	{

		$context['site'] = new Site();

		return $context;
	}

	public function add_to_twig($twig)
	{

		$twig->addFilter(new Twig_SimpleFilter('dump', 'dump' ));
		$twig->addFilter(new Twig_SimpleFilter('dd', 'dd' ));
		$twig->addFilter(new Twig_SimpleFilter('asset_url', [ $this, 'get_asset_url' ]));

		$twig->addGlobal('utils', $twig->loadTemplate('views/macros/utils.twig'));

		return $twig;
	}

	public function get_asset_url( $src ) {

		return $this->assets->get_versioned($src);

	}

	public function enqueue_scripts()
	{
		wp_deregister_script('wp-embed');
		wp_deregister_style('yoast-seo-adminbar');

		// remove jquery migrate and enqueue in footer
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );

		wp_enqueue_script('modernizr', $this->get_asset_url('scripts/modernizr.js'), false, null, false);
		wp_enqueue_script('frame-app', $this->get_asset_url('scripts/app.js'), [ 'jquery' ], null, true);
		wp_enqueue_style('frame-app', $this->get_asset_url('styles/app.css'), false, null);
	}

}