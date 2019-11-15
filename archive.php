<?php
/**
 * The template for displaying Archive pages.
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

?>
    <div class="row">
		<?php AttireFramework::DynamicSidebars( 'left' ); ?>
        <div class="<?php AttireFramework::ContentAreaWidth(); ?> attire-post-and-comments">
            <h1 class="archive-title">
				<?php the_archive_title(); ?>
            </h1>
			<?php
			do_action( ATTIRE_THEME_PREFIX . 'before_contents' );

			get_template_part( 'loop', get_post_type() );

			do_action( ATTIRE_THEME_PREFIX . 'after_contents' );
			?>
        </div>
		<?php AttireFramework::DynamicSidebars( 'right' ); ?>
    </div>

<?php get_footer();

