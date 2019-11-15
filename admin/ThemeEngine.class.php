<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( ATTIRE_TEMPLATE_DIR . "/admin/OptionFields.class.php" );


class AttireThemeEngine {

	function __construct() {
		$this->Actions();
		$this->Filters();
	}

	function Filters() {
		add_filter( 'body_class', array( $this, 'BodyClass' ), 10, 2 );
		add_filter( 'attire_layout_type', array( $this, 'PageLayout' ) );
	}

	function Actions() {
		add_action( 'wp_head', array( $this, 'WPHead' ) );
		add_action( 'admin_head', array( $this, 'adminHead' ) );

		add_action( 'widgets_init', array( $this, 'InitiateWidgets' ) );
	}

	function WPHead() {
		$this->CustomPageHeader();
		$this->CustomCSS();
	}

	function adminHead(){
	    ?>
        <style>
            .wp-block{
                max-width: 100%;
            }
        </style>
        <?php
    }


	/**
	 * @usage Custom Page Header for specific pages
	 */
	function CustomPageHeader() {

		$post_id = null;
		if ( is_page() || is_archive() || is_home() ) {
			$post_id = get_queried_object_id();

		}

		if ( ! $post_id ) {
			return;
		}

		$ph_bg_img = '';
		if ( has_post_thumbnail( $post_id ) ):
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

			$ph_bg_img = $image[0];

		endif;

		$selector = '.page_header_wrap';

		$css = "";


		$ph_bg_img     = $ph_bg_img ? $ph_bg_img : get_header_image();
		$ph_bg_color   = AttireThemeEngine::NextGetOption( 'ph_bg_color', '' );
		$ph_text_color = AttireThemeEngine::NextGetOption( 'ph_text_color', '' );
		$ph_text_align = AttireThemeEngine::NextGetOption( 'ph_text_align', 'center' );
		$pb_height     = AttireThemeEngine::NextGetOption( 'ph_bg_height', 200 );


		if ( isset( $ph_bg_img ) && $ph_bg_img != '' ) {
			$pbg = esc_url( $ph_bg_img );
			$css .= "background-image: url({$pbg});";
			$css .= "background-position: center;";
//			$css .= "background-attachment: fixed;";
			$css .= "background-repeat: no-repeat;";
		}

		if ( $ph_bg_color && $ph_bg_color != '' ) {
			$css .= "background-color: {$ph_bg_color};";
		}

		if ( $pb_height && $pb_height != '' ) {
			$css .= "min-height: {$pb_height}px;";
		}

		$text_color = '';
		if ( isset( $ph_text_color ) && $ph_text_color != '' ) {
			$text_color = "color:{$ph_text_color};";
		}


		?>
        <!-- Custom page header -->
        <style>
            <?php echo esc_attr($selector); ?>
            {
            <?php echo wp_filter_nohtml_kses($css); ?>
            }
            <?php echo esc_attr($selector).' *'; ?>
            {
                text-align: center
            ;
                vertical-align: middle
            ;
                line-height: <?php echo $pb_height?>px
            ;
            <?php echo wp_filter_nohtml_kses($text_color); ?>
            }
            #cph_title{
                text-align: <?php echo $ph_text_align; ?>
            }
        </style>
        <!-- / Custom page header -->
		<?php

	}


	/**
	 * @usage: Initiate Widgets
	 */
	function InitiateWidgets() {

		register_sidebar( array(
			'name'          => esc_html__( 'Left Sidebar', 'attire' ),
			'id'            => 'left',
			'description'   => esc_html__( 'Left Sidebar', 'attire' ),
			'before_widget' => '<div class="widget widget-default">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-heading widget-title">',
			'after_title'   => '</h4>'
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Right Sidebar', 'attire' ),
			'id'            => 'right',
			'description'   => esc_html__( 'Right Sidebar', 'attire' ),
			'before_widget' => '<div class="widget widget-default">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer1', 'attire' ),
			'id'            => 'footer1',
			'description'   => esc_html__( 'Footer1', 'attire' ),
			'before_widget' => '<div class="footer-widget  widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer2', 'attire' ),
			'id'            => 'footer2',
			'description'   => esc_html__( 'Footer2', 'attire' ),
			'before_widget' => '<div class="footer-widget  widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer3', 'attire' ),
			'id'            => 'footer3',
			'description'   => esc_html__( 'Footer3', 'attire' ),
			'before_widget' => '<div class="footer-widget  widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer4', 'attire' ),
			'id'            => 'footer4',
			'description'   => esc_html__( 'Footer4', 'attire' ),
			'before_widget' => '<div class="footer-widget  widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );
		register_sidebar( array(
			'name'          => esc_html__( 'Footer5', 'attire' ),
			'id'            => 'footer5',
			'description'   => esc_html__( 'Footer5', 'attire' ),
			'before_widget' => '<div class="footer-widget  widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-heading widget-title">',
			'after_title'   => '</h5>'
		) );
	}


	public static function Layout( $default = 'wide' ) {
		$lot = AttireThemeEngine::NextGetOption( 'main_layout_type', $default );
		echo esc_attr( apply_filters( 'attire_layout_type', $lot ) );
	}

	function BodyClass( $classes, $class ) {
		if ( is_user_logged_in() ) {
			$classes[] = 'attire-logged-in';
		} else {
			$classes[] = 'attire-not-logged-in';
		}

		return $classes;
	}

	public function ThemeCustomizerCSS() {

		$theme_mod = get_option( 'attire_options' );

        $fontsdata = AttireOptionFields::GetFonts();

        $fonts = array();
        $fonts[''] = 'Default';
        foreach ($fontsdata as $font) {
            $fonts[$font->family.":".implode(",", $font->variants)] = (array)$font;
        }

        $css = '';

		/**
		 *
		 *  Conditional css
		 *
		 */

		$header_text_color = get_header_textcolor();
		if ( $header_text_color === 'blank' ) {
			$css .= '.site-title,.site-description{display:none;}';

		}

		$search_form_visibility = isset( $theme_mod['attire_search_form_visibility'] ) ? $theme_mod['attire_search_form_visibility'] : 'show';
		if ( $search_form_visibility === 'hide' ) {
//			$css .= 'header .mainmenu > .menu-item:last-child > a{padding-right:0;}';
			$css .= 'ul.ul-search{display:none;}';
		}

		if ( isset( $theme_mod['attire_back_to_top_visibility'] ) && $theme_mod['attire_back_to_top_visibility'] !== 'show' ) {
			$css .= '.back-to-top{display:none;}';
		}

		/**
		 *
		 * Container Width
		 *
		 */

		$container_width = esc_attr( $theme_mod['container_width'] );
		$css             .= "@media screen and (min-width: 1200px) {.container{max-width:{$container_width}px;}}";

		/**
		 *
		 * Body css
		 *
		 */

		$body_font_weight = intval( $theme_mod['body_font_weight'] );
		$body_font_weight = $body_font_weight != '' ? "font-weight:{$body_font_weight};" : "";
		$body_bg          = esc_attr( $theme_mod['body_bg_color'] );
		$css              .= "body {background-color:{$body_bg}}";

		$body_font_size  = intval( $theme_mod['body_font_size'] );
		$body_font_color = esc_attr( $theme_mod['body_color'] );
		$body_font       = esc_attr( $theme_mod['body_font'] );
		$font_size       = $body_font_size != '' ? "font-size:{$body_font_size}px;" : "";
		$text_color      = $body_font_color ? "color:{$body_font_color};" : "";

		if ( $body_font != '' ) {
			$font_family = isset($fonts[ $body_font ]) && $fonts[ $body_font ]['family'] != '' ? "font-family:\"{$fonts[$body_font]['family']}\", {$fonts[$body_font]['category']};" : "";
		} else {
			$font_family = '';
		}

		$css .= ".attire-content p, .attire-post-and-comments,.attire-post-and-comments p,.attire-post-and-comments article,.attire-post-and-comments ul,.attire-post-and-comments ol, 
		.attire-post-and-comments table, .attire-post-and-comments blockquote, .attire-post-and-comments pre {{$font_family}{$font_size}{$body_font_weight}{$text_color}}";
		$css .= ".site-description, .copyright-text, .attire-post-and-comments th, .attire-post-and-comments td, .attire-post-and-comments button, .attire-post-and-comments input{{$font_family}}";


		/**
		 *
		 * Headings css
		 *
		 */
		$heading_font_weight = intval( $theme_mod['heading_font_weight'] );
		$heading_font_weight = $heading_font_weight != '' ? "font-weight:{$heading_font_weight};" : "";
		$heading_font_size   = intval( $theme_mod['heading_font_size'] );
		$header_color        = esc_attr( $theme_mod['header_color'] );
		$heading_font        = esc_attr( $theme_mod['heading_font'] );
		$h1_font_size        = 'font-size:' . $heading_font_size . 'px;';
		$h2_font_size        = 'font-size:' . ceil( $heading_font_size * .7 ) . 'px;';
		$h3_font_size        = 'font-size:' . ceil( $heading_font_size * .6 ) . 'px;';
		$h4_font_size        = 'font-size:' . ceil( $heading_font_size * .4 ) . 'px;';
		$h5_font_size        = 'font-size:' . ceil( $heading_font_size * .4 ) . 'px;';
		$h6_font_size        = 'font-size:' . ceil( $heading_font_size * .3 ) . 'px;';

		$text_color = $header_color ? "color:{$header_color};" : "";

		if ( $heading_font != '' ) {
			$font_family = isset($fonts[ $heading_font ]) && $fonts[ $heading_font ]['family'] != '' ? "font-family:\"{$fonts[$heading_font]['family']}\", {$fonts[$heading_font]['category']};" : "";
		} else {
			$font_family = '';
		}

		$css .= "h1, h1 a{{$font_family}{$h1_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h2, h2 a{{$font_family}{$h2_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h3, h3 a, .archive-item .card-title.post-title a{{$font_family}{$h3_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h4, h4 a{{$font_family}{$h4_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h5, h5 a{{$font_family}{$h5_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h6, h6 a{{$font_family}{$h6_font_size}{$heading_font_weight}{$text_color}}";
		$css .= "h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, .archive-item h3.card-title.post-title a, a{ color: {$theme_mod['a_color']};}";
		$css .= ".footer-logo, .navbar-brand{{$font_family}{$h3_font_size}}";


		/**
		 *
		 * Site logo css
		 *
		 */
		$logo_height        = $theme_mod['site_logo_height'] ? intval( $theme_mod['site_logo_height'] ) : 60;
		$footer_logo_height = $theme_mod['site_logo_footer_height'] ? intval( $theme_mod['site_logo_footer_height'] ) : 60;

		$css .= ".site-logo img{max-height:{$logo_height}px;}";
		$css .= ".footer-logo img{max-height:{$footer_logo_height}px;}";


		/**
		 *
		 * Site title/description css
		 *
		 */

		$body_font_weight    = intval( $theme_mod['body_font_weight'] );
		$body_font_weight    = $body_font_weight != '' ? "font-weight:{$body_font_weight};" : "";
		$heading_font_weight = intval( $theme_mod['heading_font_weight'] );
		$heading_font_weight = $heading_font_weight != '' ? "font-weight:{$heading_font_weight};" : "";

		$site_title_text_color        = 'color:' . esc_attr( $theme_mod['site_title_text_color'] ) . ';';
		$site_footer_title_text_color = 'color:' . esc_attr( $theme_mod['site_footer_title_text_color'] ) . ';';
		$site_description_text_color  = 'color:' . esc_attr( $theme_mod['site_description_text_color'] ) . ';';

		$site_title_line_height   = "line-height:{$logo_height}px;";
		$footer_title_line_height = "line-height:{$footer_logo_height}px;";

		$css .= ".navbar-light .navbar-brand,.navbar-dark .navbar-brand,.logo-header{{$heading_font_weight}{$site_title_text_color}{$site_title_line_height}}";
		$css .= ".footer-logo{{$heading_font_weight}{$site_footer_title_text_color}{$footer_title_line_height}}";
		$css .= ".header-contents,.logo-header:hover,.footer-logo:hover{{$site_title_text_color}}";
		$css .= ".site-description,.copyright-text{{$body_font_weight}{$site_description_text_color}}";
		$css .= ".info-link > li > span, .small-menu i.fa, .social-icons-div i{{$site_description_text_color}}";


		/**
		 *
		 * Site header/footer bg css
		 *
		 */

		$site_header_bg_color = isset($theme_mod['site_header_bg_color_left']) ? esc_attr( $theme_mod['site_header_bg_color_left'] ) : '#222222';
		$site_header_bg_color_right = isset($theme_mod['site_header_bg_color_right']) ? esc_attr( $theme_mod['site_header_bg_color_right'] ) : '#555555';
		$site_header_bg_grad_angle = isset($theme_mod['site_header_bg_grad_angle']) ? esc_attr( $theme_mod['site_header_bg_grad_angle'] ) : 45;
		$site_header_bg       = "background: $site_header_bg_color linear-gradient( {$site_header_bg_grad_angle}deg, $site_header_bg_color, $site_header_bg_color_right);";
		$css                  .= ".header-div { {$site_header_bg}}";
		$css                  .= "a.gn-icon.gn-icon-menu i{ color:$site_header_bg_color;-webkit-filter: invert(100%);filter: invert(100%);}";
		$css                  .= ".sticky-menu{ {$site_header_bg}}";
		$site_footer_bg       = 'background-color:' . esc_attr( $theme_mod['site_footer_bg_color'] );
		$css                  .= ".footer-div{ {$site_footer_bg}}";


		/**
		 *
		 * Sidebar/Footer Widget Content css
		 *
		 */

		$font_size                  = intval( $theme_mod['widget_content_font_size'] );
		$widget_content_font_weight = intval( $theme_mod['widget_content_font_weight'] );
		$font_weight                = $widget_content_font_weight != '' ? "font-weight:{$widget_content_font_weight};" : "";
		$font                       = esc_attr( $theme_mod['widget_content_font'] );
		$color                      = "color:" . esc_attr( $theme_mod['widget_content_font_color'] );
		$font_size                  = $font_size != '' ? "font-size:{$font_size}px;" : "";

		if ( $font != '' ) {
			$font_family = isset($fonts[ $font ]) && $fonts[ $font ]['family'] != '' ? "font-family:\"{$fonts[$font]['family']}\", {$fonts[$font]['category']};" : "";
		} else {
			$font_family = '';
		}

		$css .= ".widget, .widget li, .widget p {{$font_family}{$font_size}{$font_weight}}";
		$css .= ".attire-content .widget, .attire-content .widget li, .attire-content  .widget p {{$color}}";


		/**
		 *
		 * Sidebar/Footer Widget title css
		 *
		 */

		$widget_title_font_weight = intval( $theme_mod['widget_title_font_weight'] );
		$font_size                = intval( $theme_mod['widget_title_font_size'] );
		$font_weight              = $widget_title_font_weight != '' ? "font-weight:{$widget_title_font_weight};" : "";
		$font                     = esc_attr( $theme_mod['widget_title_font'] );
		$color                    = "color:" . esc_attr( $theme_mod['widget_title_font_color'] );
        $background               = "background:" . esc_attr( $theme_mod['main_nav_bg'] );

		if ( $font != '' ) {
			$font_family = isset($fonts[ $font ]) && $fonts[ $font ]['family'] != '' ? "font-family:\"{$fonts[$font]['family']}\", {$fonts[$font]['category']};" : "";
		} else {
			$font_family = '';
		}

		$font_size = $font_size != '' ? "font-size:{$font_size}px;" : "";
		$css       .= ".widget .widget-title {{$font_family}{$font_size}{$font_weight}}";
		$css       .= ".attire-content .widget .widget-title {{$color};{$background}}";
        $css .= ".sticky .card{{$color};{$background}}";
        $css .= ".sticky .card .card-body *{{$color} !important;}";

		/**
		 *
		 * Main nav / Footer nav font face
		 *
		 */

		$font                 = esc_attr( $theme_mod['menu_top_font'] );
		$font_size            = intval( $theme_mod['menu_top_font_size'] );
		$menu_top_font_weight = intval( $theme_mod['menu_top_font_weight'] );
		$font_weight          = $menu_top_font_weight != '' ? "font-weight:{$menu_top_font_weight};" : "";
		$font_size            = $font_size != '' ? "font-size:{$font_size}px;" : "";

		if ( $font != '' ) {
			$font_family = isset($fonts[ $font ]) && $fonts[ $font ]['family'] != '' ? "font-family:{$fonts[$font]['family']};" : "";
		} else {
			$font_family = '';
		}

		$css .= "header .mainmenu > .menu-item a,footer .footermenu > .menu-item a, .info-link,.attire-mbl-menu li.nav-item a,input.gn-search{{$font_family}{$font_size}{$font_weight}}";

		/**
		 *
		 * Main nav / Footer nav dropdown font face
		 *
		 */
		$menu_dropdown_font_weight = intval( $theme_mod['menu_dropdown_font_weight'] );
		$font_size                 = intval( $theme_mod['menu_dropdown_font_size'] );
		$font_weight               = $menu_dropdown_font_weight != '' ? "font-weight:{$menu_dropdown_font_weight};" : "";
		$font                      = esc_attr( $theme_mod['menu_dropdown_font'] );
		$font_size                 = $font_size != '' ? "font-size:{$font_size}px;" : "";

		if ( $font != '' ) {
			$font_family = isset($fonts[ $font ]) && $fonts[ $font ]['family'] != '' ? "font-family:\"{$fonts[$font]['family']}\", {$fonts[$font]['category']};" : "";
		} else {
			$font_family = '';
		}

		$css .= "header .dropdown ul li a.dropdown-item, footer .dropdown ul li a.dropdown-item,.attire-mbl-menu .dropdown-menu li.nav-item a{{$font_family}{$font_size}{$font_weight}}";

		/**
		 *
		 * Main nav color css
		 *
		 */

		$color = "color:" . esc_attr( $theme_mod['menu_top_font_color'] ) . ";";
		$css   .= "header .mainmenu > .menu-item:not(.active) > a, header .nav i.fa.fa-search, header .dropdown-toggler, header .mobile-menu-toggle,.attire-mbl-menu li.nav-item a, input.gn-search,.attire-mbl-menu-main a.gn-icon-search,.attire-mbl-menu .dropdown-toggler i:before{{$color}}";

		$main_nav_bg = 'background-color:' . esc_attr( $theme_mod['main_nav_bg'] );
		$css         .= "#header-style-3 nav.navbar, #header-style-2 nav.navbar, .short-nav .collapse.navbar-collapse,.long-nav,#attire-mbl-menu{ {$main_nav_bg};}";

		$main_nav_hover_active_bg = 'background-color:' . esc_attr( $theme_mod['menuhbg_color'] );
		$css                      .= "header .mainmenu > .menu-item:hover, header .mainmenu > .menu-item.active,.attire-mbl-menu li.active{ {$main_nav_hover_active_bg};}";


		$main_nav_hover_active_text_color = 'color:' . esc_attr( $theme_mod['menuht_color'] );
		$css                              .= "header .mainmenu > .menu-item:hover > a, header .mainmenu > .menu-item.active > a, header .mainmenu > .menu-item:hover > .dropdown-toggler, header .mainmenu > .menu-item.active > .dropdown-toggler,#search-top:hover i,.attire-mbl-menu li.active a, .attire-mbl-menu li.active .dropdown-toggler i:before{ {$main_nav_hover_active_text_color};}";


		/**
		 *
		 * Main nav dropdown color css
		 *
		 */

		$main_nav_dd_bg = 'background-color:' . esc_attr( $theme_mod['menuhbg_color'] );
		$css            .= "header .mainmenu > .dropdown > li, .default-menu.navbar-light .nav-search .form-control,.attire-mbl-menu .dropdown-menu li{{$main_nav_dd_bg};}"; // Search box bg color + main nav dd bg

		$main_nav_dd_text = 'color:' . esc_attr( $theme_mod['menu_dropdown_font_color'] );
		$css              .= "header .mainmenu > .dropdown li *, .default-menu.navbar-light .nav-search .form-control,.attire-mbl-menu .dropdown-menu li a{{$main_nav_dd_text};}"; // Dropdown + search field input text color

		$css                  .= '@media screen and (min-width: 1000px) {';
		$main_nav_dd_hover_bg = 'background-color:' . esc_attr( $theme_mod['menu_dropdown_hover_bg'] );
		$css                  .= "header .mainmenu > .dropdown li:hover{{$main_nav_dd_hover_bg};}";

		$main_nav_dd_hover_text = 'color:' . esc_attr( $theme_mod['menu_dropdown_hover_font_color'] );
		$css                    .= "header .mainmenu > .dropdown li:hover > *, header .mainmenu > .dropdown li:hover > .dropdown-toggler *{{$main_nav_dd_hover_text};}";
		$css                    .= '}';


		/**
		 *
		 * Footer nav color css
		 *
		 */

		$color = "color:" . esc_attr( $theme_mod['footer_nav_top_font_color'] ) . ";";
		$css   .= "footer a, footer .footermenu > .menu-item:not(.active) > a, footer .dropdown-toggler{{$color}}";

		//$footer_nav_bg = 'background-color:' . esc_attr( $theme_mod['footer_nav_bg'] );
		//$css           .= "footer .footermenu { {$footer_nav_bg};}";

		//$footer_nav_hover_active_bg = 'background-color:' . esc_attr( $theme_mod['footer_nav_hbg'] );
		//$css                        .= "footer .footermenu > .menu-item:hover,footer .footermenu > .menu-item.active{{$footer_nav_hover_active_bg};}";

		$footer_nav_hover_active_text = 'color:' . esc_attr( $theme_mod['footer_nav_ht_color'] );
		$css                          .= "footer a:hover, footer .footermenu > .menu-item:hover > a,footer .footermenu > .menu-item.active > a, footer .footermenu > .menu-item:hover > .dropdown-toggler,footer .footermenu > .menu-item.active > .dropdown-toggler{{$footer_nav_hover_active_text};}";


		/**
		 *
		 * Footer nav dropdown color css
		 *
		 */

		$footer_nav_dd_bg = 'background-color:' . esc_attr( $theme_mod['footer_nav_hbg'] );
		$css              .= "footer .footermenu .dropdown li{ {$footer_nav_dd_bg};}";

		$footer_dropdown_font_color = "color:" . esc_attr( $theme_mod['footer_nav_dropdown_font_color'] ) . ";";
		$css                        .= "footer .footermenu .dropdown li *{{$footer_dropdown_font_color}}";

		$footer_nav_dd_hover_bg = 'background-color:' . esc_attr( $theme_mod['footer_nav_dropdown_hover_bg'] );
		$css                    .= "footer .footermenu > .dropdown li:hover{ {$footer_nav_dd_hover_bg};}";

		$footer_nav_dd_hover_text = 'color:' . esc_attr( $theme_mod['footer_nav_dropdown_hover_font_color'] );
		$css                      .= "footer .footermenu > .dropdown li:hover *{{$footer_nav_dd_hover_text};}";


		/**
		 *
		 * Footer widget css
		 *
		 */

		$css .= ".footer-widgets-area {background-color : " . esc_attr( $theme_mod['footer_widget_bg_color'] ) . "}";
		$css .= ".footer-widgets .widget-title, .footer-widgets-area .widget-heading {color : " . esc_attr( $theme_mod['footer_widget_title_font_color'] ) . "}";
		$css .= ".footer-widgets .widget *:not(.widget-title):not(input){color : " . esc_attr( $theme_mod['footer_widget_content_font_color'] ) . "}";

		/**
		 *
		 * Link (<a>) color
		 *
		 */
		$a_color = 'color:' . esc_attr( $theme_mod['a_color'] );
		$css     .= ".attire-content a:not(.btn),.small-menu a:not(.btn){{$a_color};}";

		$a_hover_color = 'color:' . esc_attr( $theme_mod['ah_color'] );
		$css           .= ".attire-content a:not(.btn):hover,.small-menu a:not(.btn):hover{{$a_hover_color};}";

		return apply_filters( ATTIRE_THEME_PREFIX . 'customisation_css', $css );
	}

	/**
	 * @usage Generate custom css
	 */
	function CustomCSS() {

		$font_css = self::ThemeCustomizerCSS();
		echo "<style type='text/css'> {$font_css}</style>";

	}

	public static function AttireBodySchema() {

		$blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

		$itemtype = 'WebPage';

		$itemtype = ( $blog ) ? 'Blog' : $itemtype;

		$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;

		$result = esc_attr( apply_filters( 'attire_body_itemtype', $itemtype ) );

		echo "itemtype='http://schema.org/$result' itemscope='itemscope'";
	}

	public static function NextGetOption( $index = null, $default = null ) {
		global $attire_options;

		$attire_options = get_option( 'attire_options' );
		if ( ! empty( $attire_options[ $index ] ) ) {
			return $attire_options[ $index ];
		} else {
			return $default;
		}
	}


	public static function SiteLogo() {

		$custom_logo_id = get_theme_mod( 'custom_logo' );

		$image   = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		$logourl = esc_url( $image[0] ); // source : https://codex.wordpress.org/Theme_Logo

		if ( $logourl ) {
			$image_id = attachment_url_to_postid( $logourl );
			$meta     = wp_prepare_attachment_for_js( $image_id );

			return "<img src='{$logourl}' title='" . esc_attr( $meta['title'] ) . "' alt='" . esc_attr( $meta['alt'] ) . "' />";
		} else {
			return '<h1 class="logo-header site-title">' . esc_html( get_bloginfo( 'name' ) ) . '</h1>';
		}
	}

	public static function FooterLogo() {
		$logourl = esc_url( self::NextGetOption( 'site_logo_footer' ) );


		if ( $logourl ) {
			$image_id = attachment_url_to_postid( $logourl );
			$meta     = wp_prepare_attachment_for_js( $image_id );

			return "<img src='{$logourl}' title='" . esc_attr( $meta['title'] ) . "' alt='" . esc_attr( $meta['alt'] ) . "' />";
		} else {
			return esc_html( get_bloginfo( 'sitename' ) );
		}
	}


	function PageLayout( $type ) {
		global $post;
		$data = maybe_unserialize( get_post_meta( $post->ID, 'attire_post_meta', true ) );

		if ( is_page() && $post->ID != '' && isset( $data['pagelayout'] ) && $data['pagelayout'] != '' ) {
			$type = sanitize_text_field( $data['pagelayout'] );
		}

		return $type;
	}


	public static function HeaderStyle() {


		$style = '';
		if ( is_page() || is_single() ) {
			$attire_post_meta = get_post_meta( get_the_ID(), 'attire_post_meta', true );
			$style            = isset( $attire_post_meta['nav_header'] ) ? sanitize_text_field( $attire_post_meta['nav_header'] ) : '';
		}

		if ( ! isset( $style ) || $style == '' ) {
			$style = sanitize_text_field( self::NextGetOption( 'nav_header', 'header-1' ) );
		}

		if ( ! locate_template( "templates/headers/" . $style . ".php" ) ) {
			$style = 'header-1';
		}
		load_template( locate_template( "templates/headers/" . $style . ".php" ) );
		wp_reset_postdata();

	}


	public static function PageHeaderStyle() {

		global $post;
		$title = '';
		if ( is_home() ) {
			$post_id = get_option( 'page_for_posts' );
			$title   = get_the_title( $post_id );
		} elseif ( $post ) {
			$post_id = $post->ID;
			$title   = get_the_title( $post_id );
		}

		?>

        <div class="page_header_inner container">
            <h1 id="cph_title"><?php echo esc_html( $title ); ?></h1>
        </div>

		<?php

		wp_reset_postdata();

	}


	public static function FooterStyle() {


		$style = '';
		if ( is_page() || is_single() ) {
			$attire_post_meta = get_post_meta( get_the_ID(), 'attire_post_meta', true );
			$style            = isset( $attire_post_meta['footer_style'] ) ? sanitize_text_field( $attire_post_meta['footer_style'] ) : '';
		}

		if ( ! isset( $style ) || $style == '' ) {
			$style = sanitize_text_field( self::NextGetOption( 'footer_style', 'footer4' ) );
		}

		if ( ! locate_template( "templates/footers/" . $style . ".php" ) ) {
			$style = 'footer4';
		}
		load_template( locate_template( "templates/footers/" . $style . ".php" ) );
		wp_reset_postdata();
	}

}

new AttireThemeEngine();
 

