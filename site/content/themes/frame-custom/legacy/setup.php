<?php


add_action('init', 'setup_legacy_url');

function setup_legacy_url()
{
    add_rewrite_tag('%legacy%', '([^&]+)');
    add_rewrite_rule('^legacy/?', 'index.php?legacy=true', 'top');
}


add_action('wp_head', 'redirect_legacy_browsers');

function redirect_legacy_browsers()
{
    echo '<!--[if lt IE 9]>'
    . '<meta http-equiv="refresh" content="0;URL=\'' . home_url() . '/legacy' . '\'" />'
    . '<style type="text/css" > body{ display: none; } </style>'
    . '<![endif]-->';
}


add_filter('template_include', 'load_legacy_view', 99);

function load_legacy_view($template)
{
    if (get_query_var('legacy', false)) {
        $newTemplate = locate_template([ 'legacy/view.php' ]);

        if ($newTemplate != '') {
            return $newTemplate;
        }
    }

    return $template;
}
