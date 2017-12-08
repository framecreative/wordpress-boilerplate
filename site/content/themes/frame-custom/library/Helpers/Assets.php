<?php

namespace Frame\Helpers;

/**
 * Get paths for assets
 */

class Assets
{
    private $manifest;

    public function __construct()
    {

    	$manifest_path = get_template_directory() . '/built/' . 'versions.json';

        if (file_exists($manifest_path)) {
            $this->manifest = json_decode(file_get_contents($manifest_path), true);
        } else {
            $this->manifest = [];
        }
    }

    public function get_versioned($path)
    {

        if (isset($this->manifest[$path])) {

        	$path = $this->manifest[$path];

        }

		return get_template_directory_uri() . '/built/' . $path;

    }

}
