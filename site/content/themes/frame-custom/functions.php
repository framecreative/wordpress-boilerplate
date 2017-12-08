<?php

namespace Frame;

if ( !class_exists('Timber') ) throw new \Exception("Timber was not found.\n");

function App() {
	return App::instance();
}

App()->setup();