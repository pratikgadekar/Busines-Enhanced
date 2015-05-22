<?php
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
define('DB_NAME', 'business_enh');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         't*y}oE&~&~;d7+^!r(-,fGJhsR4DdRJVCC|:@#i-^w:m-@X,(qr^D76XC+7E*a8s');
define('SECURE_AUTH_KEY',  'F!W<5V7gIntF&6y1ROIoOEI?J2Cv|hglYIRFeho|2*]HP)1Z88|:Ae;DZv9^nNE9');
define('LOGGED_IN_KEY',    'U.6LY_ThBfu9g=Xl]3bh|`0zK%hxR,$E769Nfv@SY#eY}I+!uZY0V7-HM#~LZTG<');
define('NONCE_KEY',        '5-xT+b2CntowIeh-*9+]C:6JFeM0s;n;|pxaFE C}}POE6GQ$p}+:Rj8^W-;#Dxl');
define('AUTH_SALT',        '!p0Lo<h4+lW6+_7*%Y.?0g(FccwWCL<,3(|P,BP>MbaFrZ+0^^prdS+orvc78.qe');
define('SECURE_AUTH_SALT', 'M e4yKI]4R^.Yk7d&b;VIgPwc8:J&_GmA^eZ=#ogbX8V-%+E|@.v6KP,]Cyqm,A0');
define('LOGGED_IN_SALT',   'p%Fna(AM|m)5)u$TknS-U]pRo:x0&oCHj{b!~JF@NC-<cL4_]<Cyh..K!T5*W38{');
define('NONCE_SALT',       '*{q7z:.| [+d?MAy?xk6P:kS .Fsb/DyIWXh]I6Xm.[>c@FI>2]CpTp=Lc6Mm6Ho');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
