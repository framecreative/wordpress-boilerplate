<?php

namespace Frame\Setup;

class Admin {

	function setup()
	{

		add_action('admin_menu', [ $this, 'modify_admin_menu' ]);
		add_filter('acf/fields/wysiwyg/toolbars', [ $this, 'setup_wysiwyg_toolbars' ]);
		add_filter('tiny_mce_before_init', [ $this, 'setup_wysiwyg_formats' ]);

		add_filter('wpseo_metabox_prio', function () { return 'low'; });
		add_filter('wpseo_use_page_analysis', '__return_false');

	}

	public function modify_admin_menu()
	{

		/*

		*** Remove Posts from Admin Menu ***

		remove_menu_page('edit.php');

		*/
	}

	public function setup_wysiwyg_toolbars( $toolbars )
	{

		/*

		*** Modify WYSIWYG toolbars ***

		$toolbars = [

			'Full' => [
				'1' => [
					'formatselect',
					'bold',
					'bullist',
					'numlist',
					'link',
					'unlink',
					'pastetext',
					'removeformat',
					'charmap'
				)
			),

			'Basic' => [
				'1' => [
					'bold',
					'link',
					'unlink',
					'pastetext',
					'removeformat',
					'charmap'
				)
			)

		);

		*/

		return $toolbars;
	}

	public function setup_wysiwyg_formats( $settings )
	{

		/*

		*** Define WYSIWYG element options ***

		$settings['block_formats'] = 'Paragraph=p;Heading=h2;Subheading=h3';

		*/

		return $settings;
	}
	
}