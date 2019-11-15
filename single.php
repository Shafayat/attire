<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();
$meta_position = AttireThemeEngine::NextGetOption( 'attire_single_post_meta_position', 'after-title' );

?>
    <div class="row">
		<?php AttireFramework::DynamicSidebars( 'left' );
		do_action( ATTIRE_THEME_PREFIX . "before_main_content_area" );
		?>
        <div class="<?php AttireFramework::ContentAreaWidth(); ?> attire-post-and-comments">
            <div id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>

				<?php

				while ( have_posts() ): the_post(); ?>
                <div class="single-post-content mb-3">
					<?php the_post_thumbnail( 'full' ); ?><br>
                    <div class="">
                    <h1><?php
						do_action( ATTIRE_THEME_PREFIX . 'before_post_title' );
						the_title();
						do_action( ATTIRE_THEME_PREFIX . 'after_post_title' );
						?></h1>

					<?php
					if ( $meta_position === 'after-title' ) {
						get_template_part( 'single', 'post-meta' );
					} ?>
                    <div <?php post_class( 'post' ); ?>>

                        <div class="entry-content">
							<?php the_content(); ?>
                        </div>
                        <div class="clear"></div>

						<?php wp_link_pages(); ?>
                        <div class="clear"></div>



                    </div>
                    </div>
                    <?php
                    if ( $meta_position === 'after-content' ) {
                        get_template_part( 'single', 'post-meta' );
                    } ?>
                </div>
                    <?php if ( has_tag() ) { ?>
                        <div class="single-post-tags card">
                            <!-- div class="card-header tag-title"><?php echo esc_html__( 'Post Tags', 'attire' ); ?></div -->
                            <div class="card-body">
                            <?php the_tags( '<div class="post-tags">', ' ', '</div>' ); ?>
                            </div>
                        </div>

                    <?php } ?>
                    <div class="card single-post-author">
                    <div class="card-body">
                        <div class="post-author-info">

                            <div class="media">
                                <img class="mr-3 mb-3 circle author-image"
                                     src="<?php echo esc_url( get_avatar_url( get_the_author_meta( 'ID' ), array( 'size' => 128 ) ) ); ?>"
                                     alt="<?php esc_attr_e( 'Author Avatar', 'attire' ) ?>">
                                <div class="media-body">
                                    <h3 class="author-name mt-0"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h3>
                                    <?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                    <?php if(comments_open()){ ?>
                    <div class=" mx_comments">
                    <div class="">

						<?php comments_template(); ?>
                    </div>
                    </div>
                    <?php } ?>
				<?php endwhile; ?>
            </div>
        </div>
		<?php
		do_action( ATTIRE_THEME_PREFIX . "after_main_content_area" );
		AttireFramework::DynamicSidebars( 'right' ); ?>
    </div>


<?php get_footer();
