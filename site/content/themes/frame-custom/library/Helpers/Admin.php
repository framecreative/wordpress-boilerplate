<?php

namespace Frame\Helpers;

class Admin {

	public static function custom_icon( $path )
	{

		$path = get_template_directory() . '/' . $path;

		if (!file_exists($path)) {
			return '';
		}

		$icon = file_get_contents($path);
		$icon = 'data:image/svg+xml;base64,' . base64_encode($icon);

		return $icon;
	}

}