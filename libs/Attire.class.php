<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Attire {

	public $attire_defaults;

	function __construct() {
		$this->RegisterNavMenus();
		$this->Filters();
		$this->Actions();

		add_action( 'after_setup_theme', array( $this, 'ThemeSetup' ) );
	}

	/**
	 * Usage: Load language file
	 */
	function LoadTextDoamin() {
		load_theme_textdomain( 'attire', get_template_directory() . '/languages' );
	}

	function Filters() {

	}

	function Actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueueScripts' ) );
	}


	/**
	 * @usage Load all necessary scripts & styles
	 */
	function enqueueScripts() {
		$theme_mod = get_option( 'attire_options' );

		// Font Options ( From Customizer Typography Options )
		$family[] = sanitize_text_field( $theme_mod['heading_font'] );
		$family[] = sanitize_text_field( $theme_mod['body_font'] );
		$family[] = sanitize_text_field( $theme_mod['widget_title_font'] );
		$family[] = sanitize_text_field( $theme_mod['widget_content_font'] );
		$family[] = sanitize_text_field( $theme_mod['menu_top_font'] );
		$family[] = sanitize_text_field( $theme_mod['menu_dropdown_font'] );

		$family = array_unique( $family );

//		echo '<pre>'.json_encode($theme_mod,JSON_PRETTY_PRINT).'</pre>';

		$cssimport = '//fonts.googleapis.com/css?family=' . implode( "|", $family );
		$cssimport = str_replace( '||', '|', $cssimport );

        wp_enqueue_script( 'jquery' );

        //attire-mbl-menu

		//wp_register_script( 'attire-gn-classie', ATTIRE_TEMPLATE_URL . '/mobile-menu-rss/js/classie.js', array(), null, true );
		//wp_enqueue_script( 'attire-gn-classie' );

		//wp_register_script( 'attire-gn-gnm', ATTIRE_TEMPLATE_URL . '/mobile-menu-rss/js/gnmenu.js', array(), null, true );
		//wp_enqueue_script( 'attire-gn-gnm' );


		wp_register_script( 'attire-sticky', ATTIRE_TEMPLATE_URL . '/js/jquery.sticky.js', array('jquery'), null, true );
		wp_enqueue_script( 'attire-sticky' );

		wp_register_style( 'attire-responsive', ATTIRE_TEMPLATE_URL . '/css/responsive.css' );
		wp_enqueue_style( 'attire-responsive' );

		wp_register_style( 'bootstrap', ATTIRE_TEMPLATE_URL . '/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstrap' );

		wp_register_style( 'attire-main', get_stylesheet_uri(), array( 'bootstrap', 'attire-responsive' ) );
		wp_enqueue_style( 'attire-main' );

		wp_register_style( 'font-awesome', ATTIRE_TEMPLATE_URL . '/fonts/fontawesome/css/all.min.css' );
		wp_enqueue_style( 'font-awesome' );

		wp_register_style( 'attire-google-fonts', $cssimport, array(), null );
		wp_enqueue_style( 'attire-google-fonts' );

        wp_register_style( 'attire-woocommerce', ATTIRE_TEMPLATE_URL . '/css/woocommerce.css' );
        if ( class_exists( 'WooCommerce' ) )
            wp_enqueue_style( 'attire-woocommerce' );

		wp_register_style( 'attire', ATTIRE_TEMPLATE_URL . '/css/attire.css' );
		wp_enqueue_style( 'attire' );

		wp_register_script( 'popper', ATTIRE_TEMPLATE_URL . '/bootstrap/js/popper.min.js', array(), null, true );
		wp_enqueue_script( 'popper' );

		wp_register_script( 'bootstrap', ATTIRE_TEMPLATE_URL . '/bootstrap/js/bootstrap.min.js', array(
			'jquery',
			'popper'
		), null, true );
		wp_enqueue_script( 'bootstrap' );

		wp_register_script( 'attire-site', ATTIRE_TEMPLATE_URL . '/js/site.js', array(
			'jquery'
		), null, true );
		wp_enqueue_script( 'attire-site' );

		wp_register_script( 'comment-reply', '', array(), null, true );
		wp_enqueue_script( 'comment-reply' );

		wp_localize_script( 'attire-site', 'sitejs_local_obj', array(
			'home_url' => esc_url( home_url( '/' ) )
		) );
	}

	function sanitize_hex_color_front( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}
	}


	/**
	 * @usage: Register nav menus
	 */
	function RegisterNavMenus() {
		register_nav_menus( array(
			'primary' => __( 'Top Menu', 'attire' )
		) );
		register_nav_menus( array(
			'footer_menu' => __( 'Footer Menu', 'attire' )
		) );
	}


	/**
	 * @usage Post Comments
	 *
	 * @param $comment
	 * @param $args
	 * @param $depth
	 */
	public static function Comment( $comment, $args, $depth ) {

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
				?>
                <li class="post pingback">
                <p>
                    Pingback: <?php comment_author_link(); ?><?php edit_comment_link( esc_html__( 'Edit', 'attire' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default :
				?>
            <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
                <div class="card">

                    <div id="comment-<?php comment_ID(); ?>" class="card-body">

                        <div class="media">
                            <img class="align-self-start mr-3 circle pull-left"
                                 src="<?php echo esc_url( get_avatar_url( $comment, array( 'size' => '64' ) ) ); ?>"
                                 alt="<?php esc_attr_e( 'Commenter\'s Avatar', 'attire' ); ?>">
                            <!-- end .avatar-box -->
                            <div class="media-body">
                                <b><?php printf( '<span class="fn">%s</span>', get_comment_author_link() ) ?></b>
                                <small class="text-muted">
                                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php printf( '&mdash; %1$s ' . esc_attr__( 'at', 'attire' ) . ' %2$s', esc_html( get_comment_date() ), esc_html( get_comment_time() ) ); ?></a>
                                </small>

								<?php comment_text() ?> <!-- end comment-content-->

                                <div class="well">
									<?php if ( $comment->comment_approved == '0' ) : ?>
                                        <em class="moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'attire' ) ?></em>
									<?php endif; ?>
                                    <div class="text-muted">
                                        <small><?php edit_comment_link( '<i class="fa fa-pencil"></i> ' . esc_html__( 'Edit', 'attire' ), ' ' ); ?></small>
                                        <small><?php comment_reply_link( array_merge( $args, array(
												'reply_text' => '&nbsp;<i class="fa fa-refresh"></i> ' . esc_html__( 'Reply', 'attire' ),
												'depth'      => $depth,
												'max_depth'  => $args['max_depth']
											) ) ) ?></small>
                                    </div>
                                </div>

                            </div> <!-- end comment-wrap-->

                        </div>
                    </div> <!-- end comment-body-->

                </div> <!-- end comment-body-->


				<?php
				break;
		endswitch;
	}


	/**
	 * usage: Setup Theme
	 */
	function ThemeSetup() {
		$this->LoadTextDoamin();
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-background' );

		add_post_type_support( 'page', 'excerpt' );

		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		$args = array(
			'default-image'      => '',
			'default-text-color' => '000',
			'width'              => 1000,
			'height'             => 250,
			'flex-width'         => true,
			'flex-height'        => true,
		);
		add_theme_support( 'custom-header', $args );
		add_theme_support( 'custom-logo' );

        add_image_size( 'attire-card-image', 600, 400, array( 'center', 'top' ) );

		if ( ! get_option( 'attire_options' ) ) {
			add_option( 'attire_options', $this->GetAttireDefaults() );
		}
	}


	public function GetAttireDefaults() {
		$this->attire_defaults = array(
			'footer_widget_number' => '3',
			'copyright_info'       => '&copy;' . esc_attr__( 'Copyright ', 'attire' ) . date( 'Y' ) . '.',

			'layout_front_page'   => 'no-sidebar',
			'front_page_ls'       => 'left',
			'front_page_ls_width' => '3',
			'front_page_rs'       => 'right',
			'front_page_rs_width' => '3',

			'layout_default_post'   => 'right-sidebar-1',
			'default_post_ls'       => 'left',
			'default_post_ls_width' => '3',
			'default_post_rs'       => 'right',
			'default_post_rs_width' => '3',

			'layout_default_page'   => 'no-sidebar',
			'default_page_ls'       => 'left',
			'default_page_ls_width' => '3',
			'default_page_rs'       => 'right',
			'default_page_rs_width' => '3',

			'layout_archive_page'   => 'no-sidebar',
			'archive_page_ls'       => 'left',
			'archive_page_ls_width' => '3',
			'archive_page_rs'       => 'right',
			'archive_page_rs_width' => '3',

			'nav_header'   => 'header-1',
			'footer_style' => 'footer4',

			'main_layout_type'                  => 'container-fluid',
			'header_content_layout_type'        => 'container',
			'body_content_layout_type'          => 'container',
			'footer_widget_content_layout_type' => 'container',
			'footer_content_layout_type'        => 'container',

			'heading_font'        => 'Rubik:400,400i,500,700',
			'heading_font_size'   => '25',
			'heading_font_weight' => '700',

			'body_font'        => 'Rubik:400,400i,500,700',
			'body_font_size'   => '14',
			'body_font_weight' => '400',

			'widget_title_font'        => 'Rubik:400,400i,500,700',
			'widget_title_font_size'   => '14',
			'widget_title_font_weight' => '500',

			'widget_content_font'        => 'Rubik:400,400i,500,700',
			'widget_content_font_size'   => '13',
			'widget_content_font_weight' => '400',

			'menu_top_font'        => 'Rubik:400,400i,500,700',
			'menu_top_font_size'   => '13',
			'menu_top_font_weight' => '400',

			'menu_dropdown_font'        => 'Rubik:400,400i,500,700',
			'menu_dropdown_font_size'   => '13',
			'menu_dropdown_font_weight' => '400',

			'site_header_bg_color_left'        => '#fafafa',
			'site_header_bg_color_right'        => '#fafafa',
			'site_header_bg_grad_angle'        => '45',
			'site_title_text_color'       => '#444444',
			'site_description_text_color' => '#666666',

			'site_footer_bg_color'         => '#435ec4',
			'site_footer_title_text_color' => '#ffffff',

			'menu_top_font_color'            => '#ffffff',
			'main_nav_bg'                    => '#435ec4',
			'menuhbg_color'                  => '#ffffff',
			'menuht_color'                   => '#000000',
			'menu_dropdown_font_color'       => '#000000',
			'menu_dropdown_hover_bg'         => '#435ec4',
			'menu_dropdown_hover_font_color' => '#ffffff',

			'footer_nav_top_font_color'            => '#a2b4f9',
			'footer_nav_bg'                        => '#435ec4',
			'footer_nav_hbg'                       => '#ffffff',
			'footer_nav_ht_color'                  => '#ffffff',
			'footer_nav_dropdown_font_color'       => '#ffffff',
			'footer_nav_dropdown_hover_bg'         => '#435ec4',
			'footer_nav_dropdown_hover_font_color' => '#ffffff',

			'body_bg_color' => '#fafafa',
			'a_color'       => '#435ec4',
			'ah_color'      => '#777777',
			'header_color'  => '#333333',
			'body_color'    => '#444444',

			'widget_title_font_color'   => '#ffffff',
			'widget_content_font_color' => '#444444',
			'widget_bg_color'           => '#ffffff',

			'footer_widget_title_font_color'   => '#000000',
			'footer_widget_content_font_color' => '#000000',
			'footer_widget_bg_color'           => '#D4D4D6',

			'attire_archive_page_post_view'      => 'excerpt',
			'attire_read_more_text'              => 'read more...',
			'attire_single_post_post_navigation' => 'show',
			'attire_single_post_meta_position'   => 'after-title',

			'container_width' => '1100',

			'copyright_info_visibility'     => 'show',
			'attire_search_form_visibility' => 'show',
			'attire_back_to_top_visibility' => 'show',
			'attire_nav_behavior'           => 'sticky',

			'site_logo_height'        => '32',
			'site_logo_footer_height' => '32'
		);

		return $this->attire_defaults;
	}
} 