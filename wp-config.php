<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'WaiterBlog');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'root');

/** Adresse de l’hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         's8~|69sTD}yuC0E=?_&tf]5:?e{9jpk66`CkA7_iyM{.RDb}k:G@K#4DO+>!FDC_');
define('SECURE_AUTH_KEY',  'O3g(m|Y8R/1Wrhez.vdN.Z`fu5|/+5r&Q&f24n,<IW9`hOx<tA]IX-DTfb5>L#e`');
define('LOGGED_IN_KEY',    'dihXt(7<]kl ?h$bD/4rceO-MFU=r5MMs%Z(aC}})M1YIP x.$f1Z9m!M(FIVu?M');
define('NONCE_KEY',        '[*gCnu(a;_3WBZ}=vu^USoS;/y*zr|mF.ccaxy;H^kLd>YW@{6~*tJW~$ME5InKe');
define('AUTH_SALT',        'T5NKB5-&ym(|_8X&+~Pl_eDJ4xU`+bhLv&#adFrmos%9~EU}y=k,=W7MI;7Ld;v ');
define('SECURE_AUTH_SALT', '}~>z:)@>#./2, Yh{uS1<V^_Z[xV8kf/D6]&T_NQYN@CnofHb /nx!_x+jSZY/vI');
define('LOGGED_IN_SALT',   'fb4s*?@&q{I<D|MT%k{ORw n.FtBOK%u/sqGGI$|kJw0kU@x9K>%|@-Q<z`lxAPB');
define('NONCE_SALT',       'Y1y2W*t*vN7lzk%JX8GRI.kcCgCv:eL@k?JW|zm+P(/IOx5Gu%)wWyG^xFW@25,Y');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix  = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');