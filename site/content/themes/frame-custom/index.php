<?php

use Frame\Helpers\Route;


//Route::set( is_post_type_archive('post-type'), 'PostTypeController@showArchive' );

//Route::set( is_singular('post-type'), 'PostTypeController@showSingle' );

//Route::set( is_page_template('test'), 'PageController@showTest' );

Route::set( is_page(), 'PageController@showPage' );

Route::set( is_404(), 'PageController@showError' );


/*
 * Available conditionals can be found at https://codex.wordpress.org/Conditional_Tags
 * */
