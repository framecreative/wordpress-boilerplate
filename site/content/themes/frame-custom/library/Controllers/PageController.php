<?php

namespace Frame\Controllers;

use Timber\Timber;
use Frame\Helpers\Route;

class PageController extends BaseController
{

	function __construct()
	{

		parent::__construct();

		/*

		*** Add to controller-wide Timber context ***

		*/


	}

	public function showPage()
	{

		$this->context['page'] = Timber::get_post();

		Route::view( 'page.twig', $this->context );

	}

	public function showError()
	{

		Route::view('404.twig', $this->context);

	}

}