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
define('DB_NAME', 'biophar4_wor0253');

/** MySQL database username */
define('DB_USER', 'biophar4_wor0253');

/** MySQL database password */
define('DB_PASSWORD', 'S7qKf9td');

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
define('AUTH_KEY', 'IGOTvKO$duuOm|vR;eA=$t;]G)*a-mNO[b_>NuN=OfqV?!Df{!qOoXv-Eg^ScUhTO*I*G&VV)v%Xg/VvMWy*Df]vZcvESZY|p}B!kM{}duZZ(g]BE%^>TsTwoK<kU@Uy');
define('SECURE_AUTH_KEY', '<<mLm-IzG-%!=Q_lJJh-kX}EX^@UhD*uIWec(_!bb;>>$!W^L^wld|E_xhybR*h(%dQs-NFK@TSh=%d]Lu;<gGm^>>NelqyC}!<W][NJXBuMHYNsaZf)gD+WZ@/@WA{!');
define('LOGGED_IN_KEY', '-f(gUDpJXVlG;n_?wQKowzNb$Wy!oh{mQw?q+A=UqPfPRH<[k_seDvF}Cxmh=xp_B[%)uTbSVxEYBR+?iAxaUaxTYsjR^Hi!_rS/fg=V[^z[C^[O|]qo)WCnHG@&&h@a');
define('NONCE_KEY', '@t=(cOxqt*+xUE|ZGsY^-qEJ/GiC^ARRFzeS|UNei+JV]%$[b&kd_De?rev](U@JtSNYmw{(*IRJX>CDdy^^Pxi&o+RkuDYsF?K;^tTZsuznhco+hwWTjRpdmIMap;tM');
define('AUTH_SALT', 'AjUIVGx]DlrYr|UF;=L=Zi%)HS|n;{zg-HVe+CTx$=HjitVUiJM_(At]uAunpspDght&QBfyW^}r_qlvu/kQ=kASztUvkXk^a}oZ(t-GWV>=hPai&=v|z=DMlJoMEr@P');
define('SECURE_AUTH_SALT', 'eh=Jskiq=Pf_<-mywIZyymK)@amKEqTpjjZ}nx<x%U=+?Y(PPgdbVj|fuO+?$t=hE$fe{je!bQd)/u_cB!hHVNv}_kn>e*So*>clvgqme*yj!-WfBsV&e/[HLiBCj^hK');
define('LOGGED_IN_SALT', '|Mk]v*_$TlGDaJgQEd@glscVDd;gOFP_gh}R-Nks_/T=-r*^kh|{%n>^$+wIQajVryrK+%gK|wlc(H}qPZtYMbecHVoYJq/tr=p*%R|BmRvRS$UpyWoz$UvFKcPbM(XX');
define('NONCE_SALT', 'rQrQ^{eb;*OY!WTujgG@PKd$?B&IUSe@srg?(qi-BTeIqxGD%tHoTceDB)RO*k&uq%t+^kKdnB${]K>VV]XzpvZGM/Q|$JO!_v*v@rdGRIWl]sS*_T[)Gh;ssAtBp[%R');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_bpyo_';

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
