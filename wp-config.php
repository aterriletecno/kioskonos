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
define( 'DB_NAME', 'wp_kioskonos' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '07Uh94!SV{ap7@GuQx~xqk#%V+W2]m.og$C@m87^HUw:bZy903z3%/0a]Y{(%&KB' );
define( 'SECURE_AUTH_KEY',  '^*W?86?[^YM.J?r^C-/^RW`4ph]fgxe]tpZFWP ]. :$O2Ab}gmCmL;Amu%F2Ykh' );
define( 'LOGGED_IN_KEY',    '!pSc^4Yn-1RU=]eb(vGn_o@t;X@vN}0}$d.UAW;<,XU|t9{9|%<UQ#+R<6KTq?9G' );
define( 'NONCE_KEY',        'x1s%y^MWapm[;B>Y(5nT%znr2BAzn6Z@Brj]YARtfwOtKYR7#`ou]9<``Nna0o!X' );
define( 'AUTH_SALT',        'F(JOy{O?|G%_avCDh=&LzoR2No2`-5trS3 J]~C[Cn0~tkR(T%WX((M $& vcU?.' );
define( 'SECURE_AUTH_SALT', 'LT+FSQWI>(>|% >a#)^Yt/t>h=Ta&X>hMRK<p1zHs9NS[6P(^?br@@^I8GTeHPgl' );
define( 'LOGGED_IN_SALT',   '#mIkS[F@mXC Ww<M[X Ry%inguWA>v[_$d|+PS@_oT0;yu}1;jvgW|mSO%)kxMnR' );
define( 'NONCE_SALT',       'Rs~nN-Bt~KE#rJ^;tpL,/sdpAtd=YeejO,je|*P~-U3TcKaC2y<;eF-x[c(^Su6m' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );
define( 'FS_METHOD', 'direct' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
