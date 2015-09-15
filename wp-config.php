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
if ( preg_match('/.*local.*/i', $_SERVER['HTTP_HOST']) ){
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'autoinsurance');
  define('DB_USER', 'root');
  define('DB_PASSWORD', 'root');
} elseif (preg_match('/.*\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}.*/i', $_SERVER['HTTP_HOST']) || preg_match('/.*staging*/i', $_SERVER['HTTP_HOST'])) {
  define('DB_HOST', 'soda-staging.ccwdulihds38.us-east-1.rds.amazonaws.com');
  define('DB_NAME', 'autoinsurance');
  define('DB_USER', 'soda');
  define('DB_PASSWORD', 'denkma82');
	define('WP_HOME','http://54.152.109.187/auto-insurance/');
	define('WP_SITEURL','http://54.152.109.187/auto-insurance/');
} else {
  define('DB_HOST', 'reviews-new-articles.ccwdulihds38.us-east-1.rds.amazonaws.com');
  define('DB_NAME', 'autoinsurance');
  define('DB_USER', 'reviews');
  define('DB_PASSWORD', 'reviews1!');
	define('WP_HOME','http://www.reviews.com/auto-insurance/');
	define('WP_SITEURL','http://www.reviews.com/auto-insurance/');
}

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
define('AUTH_KEY',         'XM03L5[8w+#Djd+gz({M{S.nhqGb>.m0{ J^oCqch+06m_o>OslBbtr8%Z,Xy04w');
define('SECURE_AUTH_KEY',  '<hWm?s!05,GtHa>O-iGVO(rjCdk#<UFqxg!=T4d@,6t2leO^c}6O;x7-</@R0}#r');
define('LOGGED_IN_KEY',    '6s7Mbl%~~%f-jUd|1-tf6T9P(L|[{;%~kA9MO*^M%CF}t0Aw|[qcY%%c+dxq1iW3');
define('NONCE_KEY',        'DmC$x`Qo-I*=BEMkbkkzx$2K9l{2u_p+X#T>;4++I|vcn+SaxC#[nZ5-O>-+j,Y.');
define('AUTH_SALT',        'S#BZm{.Zw5GM,5QSD56xb1k|9f:q<5^@+S$q(d2W|Bb,k|D NTK|/|bA[@~V-52|');
define('SECURE_AUTH_SALT', ',|Z+S${F2.%bVfcIEx,<jJlz0x<r6]<Go2+7+A?#qg}~oF-=l+=|z<sakENbK/~Q');
define('LOGGED_IN_SALT',   'T3agU!]TnD$|f1vl3%{eswZOz-N0{iS+#Kno=w_=$ci89)%SZMTZ|&R`LAWyu7s2');
define('NONCE_SALT',       'Mi]eyhIHq+aN^jC|@&gq?vaV~!U0x(s&J+o_u%F-V8Pa@@_4-rxK3sX{3FD42O%B');

/**#@-*/

/**
 * AWS Access Keys for S3 Access
 */
define( 'AWS_ACCESS_KEY_ID', 'AKIAJA5RVVXLMKXADXBQ' );
define( 'AWS_SECRET_ACCESS_KEY', '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' );

define('SITEORIGIN_PANELS_NOCACHE', true);
define('SITEORIGIN_PANELS_DEV', true);

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
