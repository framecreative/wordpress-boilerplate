<?php

namespace Frame\Helpers;

use Timber\Timber;

class Route
{

	private static $_output = false;

	/**
	 * Call a controller::method based on a truthy condition.
	 *
	 * @param bool $check        A truthy check to proceed or not.
	 * @param string $controller A controller::method to call.
	 * @throws \Exception
	 * @return object/null
	 * @static
	 */

	public static function set( $check = false, $controller )
	{
		if ( !$check || is_null($check) || self::$_output ) return null;

		self::$_output = true;

		if (!isset($controller) || is_null($controller)) {
			throw new \Exception("No controller specified\n");
		}

		$pieces = explode('@', $controller);
		$controller = 'Frame\Controllers\\'.$pieces[0];
		$useController = new $controller;

		if (isset( $pieces[1]) && method_exists( $useController, $pieces[1] ) ) {
			$method = $pieces[1];
			return $useController->$method();
		}

		throw new \Exception("No controller method specified\n");
	}

	/**
	 * Handover the view template and context to Timber::render.
	 *
	 * @param string $template
	 * @param mixed $context
	 * @return void
	 * @static
	 */
	public static function view($template, $context = false)
	{
		if (is_null($template)) return;

		Timber::render($template, $context);

		if ( defined('TEMPLATE_DEBUG') && TEMPLATE_DEBUG ) {

			echo '<div style="background-color:#18171B;padding:20px;margin-top:50px">';
			dump('======= Dev only =======', $context, 'Current template: '.$template);
			echo '</div>';

		}

	}

}