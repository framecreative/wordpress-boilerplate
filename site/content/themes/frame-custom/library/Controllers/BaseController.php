<?php

namespace Frame\Controllers;

use Timber\Timber;

class BaseController
{

	protected $context;

	function __construct()
	{

		$this->context = Timber::get_context();

		/*

		*** Add to global Timber context ***

		$this->context['main_menu'] = new Timber\Menu( 'main-menu' );

		*/

	}

}