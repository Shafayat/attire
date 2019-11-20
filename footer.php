<?php
if (!defined('ABSPATH')) {
    exit;
}

do_action(ATTIRE_THEME_PREFIX . "body_content_after");

$canshow = AttireThemeEngine::NextGetOption('attire_back_to_top_visibility', 'show');
$canshow = $canshow === 'show' ? ' canshow' : '';
?>

</div> <!-- END: attire-content div -->
<a href="#" class="back-to-top <?php echo esc_attr($canshow); ?>" rel="nofollow">
    <i class="fas fa-angle-up"></i>
</a>
<?php
$num_widget = (int)AttireThemeEngine::NextGetOption('footer_widget_number', '3');
if ($num_widget !== 0) {
    do_action(ATTIRE_THEME_PREFIX . "before_footer_widget_area");
    ?>
    <div class="footer-widgets-area">
        <div class="<?php echo esc_attr(AttireThemeEngine::NextGetOption('footer_widget_content_layout_type', 'container')); ?> footer-widgets-outer">
            <div class="row footer-widgets">
                <?php
                $col = 12 / $num_widget;
                for ($i = 1; $i <= (int)$num_widget; $i++) {
                    echo '<div class="col-lg">';
                    dynamic_sidebar("footer" . $i);
                    echo '</div>';
                    if ($i < (int)$num_widget) {
                        do_action(ATTIRE_THEME_PREFIX . "between_footer_widgets");
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    do_action(ATTIRE_THEME_PREFIX . "after_footer_widget_area");
}
do_action(ATTIRE_THEME_PREFIX . "before_footer");

?>

<div class="footer-div">
    <?php AttireThemeEngine::FooterStyle(); ?>
</div>
<?php
wp_footer(); ?>
</div><!-- #Mainframe-->

</body>
</html>