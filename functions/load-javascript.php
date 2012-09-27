<?php
/*------------------------------
       Include jQuery Scripts
-------------------------------*/

function bk_load_all_scripts() {
    if( !is_admin() ) {
        wp_deregister_script('jquery');

        wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
        wp_register_script('galleria', get_template_directory_uri().'/js/galleria-1.2.8.min.js', 'jquery');
        wp_register_script('mosaic', get_template_directory_uri().'/js/mosaic.1.0.1.min.js', 'jquery');
        wp_register_script('colorbox', get_template_directory_uri().'/js/jquery.colorbox-.min.js', 'jquery');

        wp_enqueue_script('jquery');
        wp_enqueue_script('galleria');
    }
}

add_action('init' , 'bk_load_all_scripts');

function bk_jquery_scripts() {

    if (!is_admin()) { ?>
        <script type="text/javascript">

            function webAppLinks() {
                var a=document.getElementsByTagName("a");
                for(var i=0;i<a.length;i++) {
                    if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
                        a[i].onclick=function() {
                            window.location=this.getAttribute("href");
                            return false;
                        }
                    }
                }
            };

            jQuery(document).ready(function() {

                webAppLinks();

            });
        </script>
    <?php }
    if ( (is_singular('portfolio') || is_home()) && !is_admin() ) { ?>
        <script type="text/javascript">
            function galleryHeight() {
                var viewportWidth = jQuery(window).width();
                if (viewportWidth > 960) {
                    var viewportHeight = jQuery(window).height();
                    viewportHeight = viewportHeight - 80;
                    jQuery('#galleria').height(viewportHeight);
                }

                if (viewportWidth < 960) {
                    var viewportHeight = jQuery(window).height();
                    viewportHeight = viewportHeight - 115;
                    jQuery('#galleria').height(viewportHeight);
                }
            };

            function resizeGallery() {
                var resizeTimer;
                $(window).resize(function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(location.reload(), 100);
                });
            }

            jQuery(document).ready(function() {

                galleryHeight();

                resizeGallery();

            });
        </script>

    <?php } if (is_page_template('portfolios.php') && !is_admin() ) {
        wp_enqueue_script('mosaic'); ?>

        <script type="text/javascript">
            jQuery(function($){
                $('.fade').mosaic();
            });
        </script>
    <?php }
}

add_action('wp_head', 'bk_jquery_scripts');

?>