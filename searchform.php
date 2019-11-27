<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<ul class="nav navbar-nav ul-search">
    <li class="mobile-search">
        <form class="navbar-left nav-search nav-search-form"
              action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search" method="get">
            <div class="form-inline">
                <input name="post_type[]" value="product"
                       type="hidden">
                <input name="post_type[]" value="page"
                       type="hidden">
                <input name="post_type[]" value="post"
                       type="hidden">
                <div class="input-group">
                    <input type="search" required="required"
                           class="search-field form-control"
                           value="" name="s" title="<?php esc_attr_e( 'Search for:', 'attire' ); ?>"/>

                    <span class="input-group-addon" id="mobile-search-icon">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </li>
    <li class="dropdown nav-item desktop-search">
        <div class="overlay desktop-search">
            <a class="mk-search-trigger mk-fullscreen-trigger" href="#" id="search-button-listener">
                <div id="search-button"><i class="fas fa-search"></i></div>
            </a>
            <div class="mk-fullscreen-search-overlay" id="mk-search-overlay">
                <a href="#" class="mk-fullscreen-close" id="mk-fullscreen-close-button"><i
                            class="fas fa-times"></i></a>
                <div id="mk-fullscreen-search-wrapper">
                    <form class="mk-fullscreen-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>"
                          role="search" method="get">
                        <input name="s" type="search" value="" placeholder="<?php esc_attr_e( 'Search for...', 'attire' ); ?>"
                               class="mk-fullscreen-search-input">
                        <input name="post_type[]" value="product"
                               type="hidden">
                        <input name="post_type[]" value="page"
                               type="hidden">
                        <input name="post_type[]" value="post"
                               type="hidden">
                        <i class="fas fa-search fullscreen-search-icon"><input value="" type="submit"></i>
                    </form>
                </div>
            </div>
        </div>
    </li>
</ul>

<form class="widget-search-form"
      action="<?php echo esc_url( home_url( '/  ' ) ); ?>" role="search" method="get">

    <input name="post_type[]" value="product"
           type="hidden">
    <input name="post_type[]" value="page"
           type="hidden">
    <input name="post_type[]" value="post"
           type="hidden">
    <input type="search" class="search-field form-control"
           value="" name="s" placeholder="<?php esc_attr_e( 'Search for...', 'attire' ); ?>"/>

</form>

