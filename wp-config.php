<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache


/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');


/** MySQL database username */
define('DB_USER', 'wordpressuser');

/** MySQL database password */
define('DB_PASSWORD', '?WandN?');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '%d|XGqs$%HHo*RJE?sPFD`3IP[;R%$+S&$ck;v+83s_I`s!9Lob#=4jARa^u%2@V');
define('SECURE_AUTH_KEY', 'E$5w/R|0`@>G:7bD-cd77n<lo~F|AeL4(d]^U^DrRyXJ:Z!#2%Hw}BHd !>A%F;W');
define('LOGGED_IN_KEY', 'I&A}W4g {4I)phW&_}a@rH%rf~R-cIFLm5B8vH7k?c;njN;<D;6VzJ!EgpmjXRU`');
define('NONCE_KEY', 'j)FEp PnbHBl)tfll~6KhF#nU]xeF^$OZg*$fu}h2qtJKyUV.n;dS6r UOe+s*A&');
define('AUTH_SALT', '[fT;AJ }0sy.Q*RM<JPLc7LXhPIzv9dh$X c:?;SrpP7,<g{CWAFp~{wnxWI:0Q8');
define('SECURE_AUTH_SALT', 'kQ`cP1V6%/A!|G0t{[YdYMA!`-h3JXxTa<WPUdhxbH,;@Wk2J85>h;6&#@Hjx42x');
define('LOGGED_IN_SALT', 'Yk!eo(Cpnyh])rPq[hl< ^~#Qf=@9M.tX8y!O1{2+,Q6m:_?a>: ~4#o9Y]F/=ZU');
define('NONCE_SALT', 'T_t>LhXwd }q;!p:7h:F!6THqH@nry8~i{5T.p% o5pgEE?/M|CkX-S@pr]HPWfY');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/* http://contactform7.com/controlling-behavior-by-setting-constants/ */
define('WPCF7_AUTOP', false);

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH'))
    define('ABSPATH', dirname(__FILE__) . '/');

// iThemes Security Config Details: 2
define('FORCE_SSL_LOGIN', true); // Force SSL for Dashboard - Security > Settings > Secure Socket Layers (SSL) > SSL for Dashboard
define('FORCE_SSL_ADMIN', true); // Force SSL for Dashboard - Security > Settings > Secure Socket Layers (SSL) > SSL for Dashboard
define('FORCE_SSL_CONTENT', true);

define('DISABLE_WP_CRON', true);
define('WAN_TEST_ENVIRONMENT', true);

define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST']);
define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST']);

define('URL_API_SEARCH_SOLR', 'http://localhost:8983/solr/summarizeditemmetadata/');
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');