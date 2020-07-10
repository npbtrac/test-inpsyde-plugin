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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'wordpress' );

/** MySQL hostname */
define( 'DB_HOST', 'mariadb' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'tF^PTXM]QtG,uBw!Xv=TP#MwEP9W0H)D?JnOeQ~qefefSgmUsE$HRGKr8iPGsS5M' );
define( 'SECURE_AUTH_KEY',   'zAt:[K*Ssi~,;lp5WQ3r4!I):=,@&C[v^/l1P=f4Koe!:)EErv@QQ|%j!ihI@{Qa' );
define( 'LOGGED_IN_KEY',     ')B9AL<8/&E`R9)Y).,%&_;^}@Iv~WE{>ZT[XDTM&bIb/Cs88+~22U)}b`pXh~7^g' );
define( 'NONCE_KEY',         'N&9K*5f:OyX~a!}9<>ZEdGN/;aX*J*Lr}_ui(2ka|; y>NJZT>Q_5Fu?5T_kiiG;' );
define( 'AUTH_SALT',         '|Il=_inLBa`|0nxpe`HIs;wf+Mm_W<)}>{VAQ;(3;/D N7jK&Nogg9K]qnk})uF)' );
define( 'SECURE_AUTH_SALT',  '>U49Kee~,qs.Fz%w<FUEgfg{`Y#>4OBB.Z@Ac>K>)Yk44JDzg(c0-3F382J7S`9!' );
define( 'LOGGED_IN_SALT',    '4z7?_xXPlfPea?}b(KPLxa:G,roa20T,1q5vrb_d|>|Sl)(&#8_t==jO>..4`[9!' );
define( 'NONCE_SALT',        '>ruz5[L?uA8Z^y/#7>khy<Zf%#[6<6zHLmS/JqafN  o^T2~JoS&vUH;uB2?_%hn' );
define( 'WP_CACHE_KEY_SALT', 'B<~Pkd7sHPOz[p#,4oaD|lgtcJn[~K:.N{qm A>UgO6;Zw[[*<-| $wQg&s*Ppo;' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
