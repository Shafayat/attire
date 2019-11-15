<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class AttireMetaBoxes {
	private $metadata;
	private $meta_boxes;

	function __construct() {
		global $post;
		if ( ! empty( $post ) ) {
			$this->metadata = maybe_unserialize( get_post_meta( $post->ID, 'attire_post_meta', true ) );
		}
		$this->Actions();
	}

	function Actions() {
		add_action( 'admin_init', array( $this, 'LoadMetaBoxes' ), 0 );
		add_action( 'save_post', array( $this, 'SavePostMeta' ), 10, 2 );
	}

	function LoadMetaBoxes() {
		$this->meta_boxes = array(
			'attire-page-width' => array(
				'title'     => __( 'Page Width', 'attire' ),
				'callback'  => array( $this, 'PageWidth' ),
				'position'  => 'side',
				'priority'  => 'core',
				'post_type' => 'page'
			),
            'attire-page-sidebar' => array(
                'title'     => __( 'Sidebar Layout', 'attire' ),
                'callback'  => array( $this, 'SidebarLayout' ),
                'position'  => 'side',
                'priority'  => 'core',
                'post_type' => 'page'
            ),
            'attire-page-header' => array(
                'title'     => __( 'Page Header', 'attire' ),
                'callback'  => array( $this, 'PageHeader' ),
                'position'  => 'side',
                'priority'  => 'core',
                'post_type' => 'page'
            ),
		 
		);
		$this->meta_boxes = apply_filters( "attire_metabox", $this->meta_boxes );

		foreach ( $this->meta_boxes as $ID => $meta_box ) {
			extract( $meta_box );
			add_meta_box( $ID, $title, $callback, $post_type, $position, $priority );
		}
	}

	/**
	 * @usage Page Width
	 *
	 * @param $post
	 */
	function PageWidth( $post ) {

		if ( ! is_array( $this->metadata ) ) {
			$this->metadata = maybe_unserialize( get_post_meta( $post->ID, 'attire_post_meta', true ) );
		}

		$container_fluid = "";
		$container       = "";
		$val             = get_post_meta( $post->ID, 'attire_post_meta', true );
		if ( isset( $val['layout_page'] ) ) {
			$val = $val['layout_page'];

			$default         = $val === "default" ? "selected" : "";
			$container_fluid = $val === "container-fluid" ? "selected" : "";
			$container       = $val === "container" ? "selected" : "";

		} elseif ( $container_fluid === "" && $container === "" ) {
			$default = "selected";
		}

		wp_nonce_field( 'attire_page_layout_nonce', 'attire_page_layout_nonce' );
		echo "<div class='w3eden' style='padding-top: 10px'>";
		echo '<select class="form-control wpdm-custom-select" id="page_width" name="attire_post_meta[layout_page]">';
		echo '<option  value="default"  ' . esc_attr( $default ) . '>' . __( 'Theme Default', 'attire' ) . '</option>';
		echo '<option  value="container-fluid"  ' . esc_attr( $container_fluid ) . '>' . __( 'Full-Width', 'attire' ) . '</option>';
		echo '<option  value="container"  ' . esc_attr( $container ) . '> ' . __( 'Container', 'attire' ) . '</option>';
		echo '</select>';
		echo '</div>';



	}


	public function SidebarLayout($post)
        {

			$meta = get_post_meta( $post->ID, 'attire_post_meta', true );
			$sl = isset($meta['sidebar_layout']) ? $meta['sidebar_layout'] : 'default';
            $imageDir = '/images/layouts/';
            $imguri = get_template_directory_uri() . $imageDir;
            ?>
            <div class="attire-sb-layout">
				<div style="padding: 10px 0"><label>
                    <input <?php checked($sl, 'default') ?> type="radio" name="attire_post_meta[sidebar_layout]"
                           value="default"/> Theme Default</label>
				</div>
                <label>
                    <input  <?php checked($sl, 'no-sidebar') ?> class="layoutradio" type="radio" name="attire_post_meta[sidebar_layout]"
                           value="no-sidebar"/>
                    <img src="<?php echo esc_url($imguri); ?>no-sidebar.png"
                         alt="<?php esc_attr_e('Full Width', 'attire'); ?>"
                         title="<?php esc_attr_e('Full Width', 'attire'); ?>"/>
                </label>
                <label>
                    <input <?php checked($sl, 'left-sidebar-1') ?> class="layoutradio" type="radio" name="attire_post_meta[sidebar_layout]"
                           value="left-sidebar-1"/>
                    <img src="<?php echo esc_url($imguri); ?>left-sidebar.png"
                         alt="<?php esc_attr_e('Left Sidebar', 'attire'); ?>"
                         title="<?php esc_attr_e('Left Sidebar', 'attire'); ?>"/>
                </label>
                <label>
                    <input <?php checked($sl, 'right-sidebar-1') ?> class="layoutradio" type="radio" name="attire_post_meta[sidebar_layout]"
                           value="right-sidebar-1"/>
                    <img src="<?php echo esc_url($imguri); ?>right-sidebar.png"
                         alt="<?php esc_attr_e('Right Sidebar', 'attire'); ?>"
                         title="<?php esc_attr_e('Right Sidebar', 'attire'); ?>"/>
                </label>
                <label>
                    <input <?php checked($sl, 'sidebar-2') ?> class="layoutradio" type="radio" name="attire_post_meta[sidebar_layout]"
                           value="sidebar-2"/>
                    <img src="<?php echo esc_url($imguri); ?>sidebar-2.png"
                         alt="<?php esc_attr_e('Sidebar | Content | Sidebar', 'attire'); ?>"
                         title="<?php esc_attr_e('Sidebar | Content | Sidebar', 'attire'); ?>"/>
                </label>
                <label>
                    <input <?php checked($sl, 'left-sidebar-2') ?> class="layoutradio" type="radio"  name="attire_post_meta[sidebar_layout]"
                           value="left-sidebar-2"/>
                    <img src="<?php echo esc_url($imguri); ?>left-sidebar-2.png"
                         alt="<?php esc_attr_e('Two Left Sidebar', 'attire'); ?>"
                         title="<?php esc_attr_e('Two Left Sidebar', 'attire'); ?>"/>
                </label>
                <label>
                    <input <?php checked($sl, 'right-sidebar-2') ?> class="layoutradio" type="radio"  name="attire_post_meta[sidebar_layout]"
                           value="right-sidebar-2"/>
                    <img src="<?php echo esc_url($imguri); ?>right-sidebar-2.png"
                         alt="<?php esc_attr_e('Two Right Sidebar', 'attire'); ?>"
                         title="<?php esc_attr_e('Two Right Sidebar', 'attire'); ?>"/>
                </label>
            </div>
			<style>.layoutradio, .layoutradio:before, .layoutradio:after{ position:absolute; display: none !important; }
			.layoutradio + img{ border: 2px solid #ffffff; }
			.layoutradio:checked + img{ border: 2px solid #3399ff; }
			</style>
            <?php
        }

        function PageHeader( $post ){
            $meta = get_post_meta( $post->ID, 'attire_post_meta', true );
            $hide_site_header = isset($meta['hide_site_header']) ? (int)$meta['hide_site_header'] : 0;
            $page_header = isset($meta['page_header']) ? (int)$meta['page_header'] : -1;
            wp_nonce_field( 'attire_page_header_nonce', 'attire_page_header_nonce' );
            echo "<div class='w3eden' style='padding-top: 10px'><div class='form-group'>";
            echo '<select class="form-control wpdm-custom-select" id="page_header" name="attire_post_meta[page_header]">';
            echo '<option  value="-1"  ' . selected( -1,  $page_header, false) . '>' . __( 'Theme Default', 'attire' ) . '</option>';
            echo '<option  value="1"  ' . selected( 1,  $page_header, false) . '>' . __( 'Show', 'attire' ) . '</option>';
            echo '<option  value="0"  ' . selected( 0,  $page_header, false) . '> ' . __( 'Hide', 'attire' ) . '</option>';
            echo '</select></div>';
            echo "<div class='panel panel-default'><div class='panel-heading'>".__('Site Header', 'attire')."</div><div class='panel-body'><input type='hidden' name='attire_post_meta[hide_site_header]' value='0'><input style='margin: -2px 3px 0 0' type='checkbox' ".checked(1, $hide_site_header, false)." name='attire_post_meta[hide_site_header]' value='1' id='htm'> <label style='font-weight: normal' for='htm'> ".__("Hide Top Menu", "attire")."</label></div></div>";
            echo '</div>';
        }


	/**
	 * @usage Save Post Meta
	 *
	 * @param $postid
	 * @param $post
	 *
	 * @return void
	 */
	function SavePostMeta( $postid, $post ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $postid;
		}

		if ( ! current_user_can( 'edit_page', $postid ) ) {
			return $postid;
		}

		if ( isset( $_POST['attire_post_meta'] ) && is_array( $_POST['attire_post_meta'] ) ) {

			$pagemeta = $_POST['attire_post_meta'];

			if ( wp_verify_nonce( $_POST['attire_page_layout_nonce'], 'attire_page_layout_nonce' ) ) {
				$pagemeta['layout_page'] = sanitize_text_field( $pagemeta['layout_page'] );
			}

			update_post_meta( $postid, 'attire_post_meta', $pagemeta );
		}
	}
}

new AttireMetaBoxes();
