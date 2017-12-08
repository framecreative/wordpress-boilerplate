<?php

function env($key, $default = null)
{
    $value = getenv($key);
    if ($value === 'false') { return false; }
    if ($value === 'true') { return true; }
    if ($value === false) { return $default; }
    return $value;
}

$root_dir = dirname(__DIR__);

require_once($root_dir . '/vendor/autoload.php');

$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir)) {
    $dotenv->load();
    $dotenv->required(['WP_ENV', 'WP_DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_URL']);
}

define('WP_ENV', env('WP_ENV', 'dev'));
define('DB_NAME', env('WP_DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST', 'localhost'));

define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('WP_HOME', env('WP_URL', 'http://'.$_SERVER['HTTP_HOST']));
define('WP_SITEURL', env('WP_SITEURL', WP_HOME.'/'.env('WP_DIR', 'wordpress')));

define('WP_CONTENT_DIR', env('WP_CONTENT_DIR', __DIR__. '/content'));
define('WP_CONTENT_URL', env('WP_CONTENT_URL', WP_HOME. '/content'));

define('WP_DEFAULT_THEME', env('WP_THEME', 'frame-custom'));

$isDev = WP_ENV === 'dev';

define('WP_DEBUG', env('WP_DEBUG', $isDev));
define('WP_DEBUG_DISPLAY', env('WP_DEBUG', $isDev));
define('SCRIPT_DEBUG', env('WP_DEBUG', $isDev));
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON', false));
define('WP_CACHE', env('WP_CACHE', false));

define( 'TEMPLATE_DEBUG', env( 'TEMPLATE_DEBUG', false ) );


if ($isDev) {
    
    // Register the Whoops error handler
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();

} elseif (WP_ENV === 'staging') {
    // Specific config can go here
} elseif (WP_ENV === 'live' ||  WP_ENV === 'production') {
    // Specific config can go here
}

// https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));


$table_prefix = env('WP_PREFIX', 'frame_');

define('WPLANG', env('WPLANG', 'en_AU'));

/* Frame Core - Password Protect  */
if ($fcPassword = getenv('FC_PASSWORD_PROTECT_PASSWORD')) {
    define('FC_PASSWORD_PROTECT_ENABLE', true);
    define('FC_PASSWORD_PROTECT_PASSWORD', $fcPassword);
}

/* Frame Core - Proxy uploads */
if ($fcProxy = getenv('FC_PROXY_UPLOADS_URL')) {
    define('FC_PROXY_UPLOADS_URL', $fcProxy);
}

/* Frame Core - wp-migrate-db licence */
if ($wpmdbLicence = getenv('WPMDB_LICENCE')) {
    define('WPMDB_LICENCE', $wpmdbLicence);
}

/* Set the trash to less days to optimize WordPress. */
define('EMPTY_TRASH_DAYS', env('EMPTY_TRASH_DAYS', 7));

/* Specify the Number of Post Revisions. */
define('WP_POST_REVISIONS', env('WP_POST_REVISIONS', 2));

/* Cleanup image edits. */
define('IMAGE_EDIT_OVERWRITE', env('IMAGE_EDIT_OVERWRITE', true));

/* Prevent file edit from the dashboard. */
define('DISALLOW_FILE_EDIT', env('DISALLOW_FILE_EDIT', true));

/* Vendor path to help load custom plugins */
define('VENDORPATH', __DIR__.'/../vendor');

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
