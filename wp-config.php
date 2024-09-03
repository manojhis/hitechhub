<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hitechhub_hihubwp');

/** Database username */
define( 'DB_USER', 'hitechhub_hihubwp');

/** Database password */
define( 'DB_PASSWORD', 'VVEYow}]O!KK' );

/** Database hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '%+qxN]K:O/Oj%l9N4Lz#G5Cum~zOl3XSJn(g|0RS+*xjZQ8~%YntCU9Dxp4Aov8@');
define('SECURE_AUTH_KEY', 'w&X0F~kZ4v2D5LF830@_fZ]i839KC-u9Y3+035KZQnoMxV0bQ|)Ju17hAu;|C+!K');
define('LOGGED_IN_KEY', 'UG#0Lt@u@#bh2M/4JQ6g/el92&Y8V(Tc02T|ioY3T8)gCjP14GL*O(d2)gF#Y1f~');
define('NONCE_KEY', 'b&o4+12*01177xnH~bvSq_5Vz7gSRoR535::HI3ff1]9xm17lW~33me!60Ae;KZ@');
define('AUTH_SALT', '@ta[#!/61C5Za6JIp/:ur544WTLR!g)Dfqnt[e2TMdQ_c&092+565Gh5ve@a+(wO');
define('SECURE_AUTH_SALT', '216YwW/[@9Y_-M|m1)i5~It_h5WV*o)FqHkPR0r4[6)kKlfp461Ta;k%3d0V~W#@');
define('LOGGED_IN_SALT', 'P_bu8/Xef|!|~3A7R88Y*I&q2J2//02(M@7z1Jb73dN9x+p/1#YeElGvn6PZs_Q;');
define('NONCE_SALT', '[R/(6(2zz6GiQ+Q&ari%_ow8jp!]Q7XLwuy6E/3fmdg58B56b32j/B90RCswy9HF');


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'h2XAzkS_';


/* Add any custom values between this line and the "stop editing" line. */

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
// if ( ! defined( 'WP_DEBUG' ) ) {
// 	define( 'WP_DEBUG', false );
// }

define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', false );

define( 'DISABLE_WP_CRON', true );

define( 'CONCATENATE_SCRIPTS', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
