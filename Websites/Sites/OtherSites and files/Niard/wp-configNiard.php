<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'nice1013_niardWordpress	');

/** MySQL database username */
define('DB_USER', 'nice1013_niard	');

/** MySQL database password */
define('DB_PASSWORD', 'ray2486s3s3');

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
define('AUTH_KEY',         '3ENV67K QxLVbYq*7qD/Ay)1v=+5U|D[f0 2#Y{?Kl;lHPno-}|e?|UN7z-~qk^j');
define('SECURE_AUTH_KEY',  'ZEsTi{=ul)C]j;H|sa&?AeGBenWd]o^:rt0IKcJH&%7^h&zX4jq?|#@4#e:@CREX');
define('LOGGED_IN_KEY',    ' xOakHpe&!6&tJxUSSmpN>SaE@sT>[5R%?B{/A05?<8Y-cT>|_v! m5n3,&l>Dce');
define('NONCE_KEY',        'Jt}_~x[lYj}KqqIn:78^9aGp@o^rUUQ7}}wsDDg4<+X+8#3-x<CAnjL9:}wF#FI.');
define('AUTH_SALT',        'M!GlbU1*iRn.oN)q4-hR/XIf_e8s)d7Q+[AJXp:XeE-XIMIqZ6z8k0(zdqIi;#bs');
define('SECURE_AUTH_SALT', '; cethe]|l?k}6&q:MzhN6Y%ov.-A.+nFNB$Z|U0Aw2GBe=dhoz!}QrxENEfStlu');
define('LOGGED_IN_SALT',   '{-wP%G{!m)x+JwVf_EyS3vnGN+PT$-HiPu{Xnw;/+m 2x9s-2e&dlq=g<woL?4QW');
define('NONCE_SALT',       '^PNnh($SNx]g:Dk Qs-2b8AK3H<%PN4A2A*a!#0,kZf^+37m,=VPF4Hv_K/YmGqY');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wordpress1';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
