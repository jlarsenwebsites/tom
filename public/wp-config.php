<?php
define('DB_NAME', 'tom-wp-71JGQkvN');
define('DB_USER', 'JjQYVEprIho7');
define('DB_PASSWORD', '0QuzjXkCiogOJojU');

define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('AUTH_KEY',         'TBngt2ph3ZfBqmwfNPiJDxiB4gUfXpmyvrnWqslK');
define('SECURE_AUTH_KEY',  'deSHUCKz9eENiUCY4LkojFI9jMDxUm8RWZcbhC2y');
define('LOGGED_IN_KEY',    'F34YsBxQfixkBTxlELK8nricV1xTB9lPiEx0Qj6A');
define('NONCE_KEY',        'N0h646vM1nNzpDzGsRHag2GpUDtRuu0EtbN9wnOm');
define('AUTH_SALT',        'U85oOTDh0MDyIpkGgc40MrMZU2XNKyHhi6xe2cli');
define('SECURE_AUTH_SALT', 'c5S6chcwGRznELKkxY79cAc8Po0GPJciRLHklFTv');
define('LOGGED_IN_SALT',   'RsG2NwTg4aLk2rw7LWFKwfIUiriJVVzlZbYBVr5I');
define('NONCE_SALT',       '2jdztoLcEQ0OJD2fPU3WQfmAIQa1qjQ3KXCahUWa');

$table_prefix  = 'wp_';

define('SP_REQUEST_URL', ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);

define('WP_SITEURL', 'https://tomrobertsondfw.com');
define('WP_HOME', 'https://tomrobertsondfw.com');

define( 'AUTOSAVE_INTERVAL', '0' );
define( 'WP_POST_REVISIONS', false );
define( 'MEDIA_TRASH', false );
define( 'EMPTY_TRASH_DAYS', '0' );

/* Change WP_MEMORY_LIMIT to increase the memory limit for public pages. */
define('WP_MEMORY_LIMIT', '256M');

/* Uncomment and change WP_MAX_MEMORY_LIMIT to increase the memory limit for admin pages. */
//define('WP_MAX_MEMORY_LIMIT', '256M');

define( 'WP_AUTO_UPDATE_CORE', true );
define( 'DISALLOW_FILE_EDIT', true );

/* That's all, stop editing! Happy blogging. */

if ( !defined('ABSPATH') )
        define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');
