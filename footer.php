<?php
/**
 * Theme Name:      Meloo
 * Theme Author:    Mariusz Rek - Rascals Themes
 * Theme URI:       http://rascalsthemes.com/meloo
 * Author URI:      http://rascalsthemes.com
 * File:            footer.php
 * @package meloo
 * @since 1.0.0
 */

// Get options
$meloo_opts = meloo_opts();
?>

        </div><!-- #ajax content -->
    </div><!-- #ajax container -->

    <?php 

    // King Composer Footer Section 
    if ( function_exists('kc_add_map') ) : ?>
    <div class="container-full kc-footer-section">
        <?php
            $footer_section = get_theme_mod( 'footer_section', 'none' );

            $lang = '';
            if ( function_exists( 'pll_current_language' ) ) {
               $lang = pll_current_language(); 
            }

            if ( $footer_section !== 'none' ) {
                echo kc_do_shortcode( get_post_field( 'post_content_filtered', $footer_section ) ); 
            }

         ?>
    </div>
    <?php endif; ?>

    <!-- Footer container -->
    <footer class="footer <?php echo esc_attr( get_theme_mod( 'footer_color_scheme', 'dark' ) ) ?>-scheme-el">
        <!-- container -->
        <div class="container">
            <div class="footer-social social-icons">
            <?php 
                if ( function_exists( 'meloo_social_buttons' ) ) {
                        $footer_social_defaults = array(
                            array(
                                'social_type' => 'facebook',
                                'social_link'  => '#',
                            ),
                            array(
                                'social_type' => 'twitter',
                                'social_link'  => '#',
                            ),
                            array(
                                'social_type' => 'soundcloud',
                                'social_link'  => '#',
                            ),
                            array(
                                'social_type' => 'mixcloud',
                                'social_link'  => '#',
                            ),
                            array(
                                'social_type' => 'spotify',
                                'social_link'  => '#',
                            )
                        );
                        echo meloo_social_buttons( get_theme_mod( 'footer_social_buttons', false ) );
                    }
                ?>
            </div>
            <div class="footer-note">
                <?php 
                    echo wp_kses_post( get_theme_mod( 'copyright_note', '&copy; Copyright 2018 Meloo. Powered by <a href="#" target="_blank">Rascals Themes</a>. Handcrafted in Europe.' ) );  
                ?>
            </div>
        </div> <!-- .container -->
    </footer><!-- .footer -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>