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
define('DB_NAME', 'biophar4_wor2');

/** MySQL database username */
define('DB_USER', 'biophar4_wor2');

/** MySQL database password */
define('DB_PASSWORD', '5Dk143Mw');

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
define('AUTH_KEY',         '8kDrneenf$fBc7di&_qVdt}?#bXv,rsetj z2Y%qa@$b2jLE<?Z(UII)D&4brs^X');
define('SECURE_AUTH_KEY',  '~JWmRH:nvg-1vh~dF(%C10>^)zB%vQ!xw]1b{,@$6a_~-!5qluikN_o8R2q0[M1&');
define('LOGGED_IN_KEY',    'c=O~v[6+d+C$2.$^+eDdCE~^%[K,,;xCYouPQe=-LO)w3 7txwW[jX/dQlGKJ.S}');
define('NONCE_KEY',        ' w-dFr7(9XqDh)z;S_qA{Y t[kZj.skX,|KIM?StU#zh$8JS,]+;KzGou)V=o|(p');
define('AUTH_SALT',        'Em5K,Z~O,Cw-J}8_1M{MoFT3&YPCO^%-J6o)H/6<%fSiF5*Fl CE|=s43/K_z(Iy');
define('SECURE_AUTH_SALT', 'IL?|T-zxxkC?:1qjN61 5enu1)qt[RX#XU8W%7N?.eob#6l%:e^AFPw6wl_P5L==');
define('LOGGED_IN_SALT',   'PGn5{5NdvQ9!*yAW~ho*_xA,SMdmcq:=fe4@{*`o#tX;L1`o(P&!Nu.M`n+<Xwbp');
define('NONCE_SALT',       'jjlic6{R+5;xs=AX$0l9<4}fT-0bF%$v&s?I|g2-<PxpG2^^#5,JcLSxo>qqv?zW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wrd_';

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
define('QA_SLUG_ASK', 'ask-an-expert');
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
