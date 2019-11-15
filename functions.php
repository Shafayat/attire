<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( version_compare( PHP_VERSION, '5.2.0', '<' ) ) {

	add_action( 'after_switch_theme', 'AttireCheckPhpVersionBeforeActivation', 10, 2 );
	add_action( 'load-customize.php', 'AttireBlockCustomizer' );
	add_action( 'template_redirect', 'AttireBlockPreview' );

	return;
}

function AttireCheckPhpVersionBeforeActivation( $oldtheme_name, $oldtheme ) {


	// Info message: Theme not activated
	add_action( 'admin_notices', 'AttireNotActivatedAdminNotice' );


	// Switch back to previous theme
	switch_theme( $oldtheme->stylesheet );

	unset( $_GET['activated'] );


}

function AttireBlockCustomizer() {


	wp_die( esc_html__( 'Attire requires PHP version 5.2 or later. Please upgrade your php version for better performance/security.', 'attire' ), '', array(
		'back_link' => true,
	) );
}


function AttireBlockPreview() {

	if ( isset( $_GET['preview'] ) ) {
		wp_die( esc_html__( 'Attire requires PHP version 5.2 or later. Please upgrade your php version for better performance/security.', 'attire' ) );
	}
}

function AttireNotActivatedAdminNotice() {
	?>

    <div class="notice notice-error is-dismissible">
        <p>
            <strong><?php esc_html_e( 'Switched back to previous theme. Attire requires PHP version 5.2 or later. Please upgrade your php version for better performance/security.', 'attire' ); ?></strong>
        </p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'attire' ); ?></span>
        </button>
    </div>

	<?php
}


define( 'ATTIRE_THEME_PREFIX', 'attire_' );
define( "ATTIRE_TEMPLATE_DIR", get_template_directory() );
define( "ATTIRE_THEME_URL", get_stylesheet_directory_uri() );
define( "ATTIRE_TEMPLATE_URL", get_template_directory_uri() );


require_once( ATTIRE_TEMPLATE_DIR . "/admin/ThemeEngine.class.php" );
require_once( ATTIRE_TEMPLATE_DIR . "/libs/Framework.class.php" );
require_once( ATTIRE_TEMPLATE_DIR . "/libs/Attire.class.php" );
require_once( ATTIRE_TEMPLATE_DIR . "/libs/MetaBoxes.class.php" );
require_once( ATTIRE_TEMPLATE_DIR . "/libs/StructuredData.class.php" );
require_once( ATTIRE_TEMPLATE_DIR . '/admin/customizer.php' );

new Attire();

class AttireBase {

	function __construct() {
		$this->Actions();
		$this->Filters();

	}


	function Actions() {
		//delete_option( 'attire_options' );

	}

	function Filters() {
		add_filter( 'attire_sidebar_styles', array( $this, 'SidebarStyles' ) );
		add_filter( 'excerpt_more', array( $this, 'attire_excerpt_more' ) );
		add_filter( 'excerpt_length', array( $this, 'attire_excerpt_length' ), 999999 );
	}

	function _remove_script_version( $src ) {
		if ( ! strpos( $src, 'googleapis' ) ) {
			$parts = explode( '?', $src );

			return $parts[0];
		}

		return $src;
	}

	function SidebarStyles( $styles ) {
		$styles['boxed-panel'] = array(
			'style_name'    => __( 'Boxed Panel', 'attire' ),
			'before_widget' => '<div class="widget-boxed-panel">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-boxed-panel-heading widget-title">',
			'after_title'   => '</h3>'
		);

		return $styles;
	}

    function attire_excerpt_length( $length ) {
        return 30;
    }

	function attire_excerpt_more( $more ) {

		if ( is_admin() ) {
			return $more;
		}

		global $post;
		$more = AttireThemeEngine::NextGetOption( 'attire_read_more_text', __( 'read more...', 'attire' ) );

		return '. <a class="read-more-link" href="' . esc_url( get_permalink( $post->ID ) ) . '">' . wp_kses_post( $more ) . '</a>';
	}
}

new AttireBase();
