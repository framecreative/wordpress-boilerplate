<?php

namespace Frame;

class App
{

	protected static $_instance = null;

	public function setup()
    {

		(new Setup\Structure())->setup();

		if ( is_admin() ) {

			(new Setup\Admin())->setup();

		} else {

			(new Setup\Frontend())->setup();

		}

    }

	public static function instance()
	{
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

}


