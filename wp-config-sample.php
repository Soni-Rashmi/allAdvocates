<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'all_advocates');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'x#`~TLLKuY,k;yE3~y.@lsOrooWbXo(FHu$y>i M1+mxl(1t2xbkj*ZaPb[rz{W(');
define('SECURE_AUTH_KEY',  '_2a<J40Rfp;!El3k9con<,rY0.PW8^*BgHW;>C9))xrT-URUGA&aMPiJo3j<<J2=');
define('LOGGED_IN_KEY',    'a|&S7`}9W!m5J?yq@;.p=c[IrD9~d@}}#c2KW^i=~(@[s;:3RVgSlr! CXg6@5X7');
define('NONCE_KEY',        '@zl;Edhp1h7eF(BYbxLWSGD%dhw)2`n|j1n40gz#L1`056B:UC*Jw2VmB5UIU8%x');
define('AUTH_SALT',        'rY3-_y{]gJ/Y?QC6y7&IaS7py*D;XV=>nrgZ[79KmD@phA>}hxs%<[!j[@Mt6~6?');
define('SECURE_AUTH_SALT', 'LI||H|ns*cRjS0DX FTl>bSGj8 dBQpXG+<ISZ6X]Gay)azs!$Iu>#5ITlEw|T]{');
define('LOGGED_IN_SALT',   ':gDxOeB[;|x$SqI{ka0F1&o{2hBrjwUcg;z?Tn,KdcXRE2ZrN3B9FIxV1_t1<.(/');
define('NONCE_SALT',       ':L:Lf_5E#=1ndYJHJ<=^|5`tHw.D=qHL+93c+.L;WI5iH?gZ+GPFS[|NxvcEewDb');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
