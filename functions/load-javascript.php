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

function bk_jquery_scripts() { ?>

    <script type="text/javascript">
    <?php if (!is_admin()) { ?>

        // When ready...
        window.addEventListener("load",function() {
          // Set a timeout...
          setTimeout(function(){
            // Hide the address bar!
            window.scrollTo(0, 1);
          }, 0);
        });

        function webAppLinks() {
            var a=document.getElementsByTagName("a");
            var par = $('').closest('div','galleria-controls');
            for(var i=0;i<a.length;i++) {
                if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
                    a[i].onclick=function() {
                        window.location=this.getAttribute("href");
                        return false;
                    }
                }
            }
        };

        function menu() {
            jQuery('#pull').click(function(e) {
                e.preventDefault();
                if (jQuery('#navigation').is('.opened')) {
                    jQuery('#navigation').removeClass('opened').addClass('closed');
                } else {
                    jQuery('#navigation').removeClass('closed').addClass('opened');
                }
            })
        }

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

            if (viewportWidth < 767) {
                var viewportHeight = jQuery(window).height();
                viewportHeight = viewportHeight - 45;
                jQuery('#galleria').height(viewportHeight);
            }
        };

        jQuery(document).ready(function() {

            webAppLinks();

            galleryHeight();

            menu();

        });

    <?php } if ( (is_singular('portfolio') || is_home()) && !is_admin() ) { ?>

        function reloadGalleria() {
            location.reload();
        };

        var resizeTimer;
        $(window).resize(function() {
            var w = jQuery(window).width();
            var gWidth = jQuery('.galleria-container').width();

            var full = $('.galleria-container').hasClass('fullscreen');

            if (w < 1100 && !full) {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(reloadGalleria, 200);
            }
        });

    <?php } if (is_page_template('portfolios.php') && !is_admin() ) { ?>

        <?php wp_enqueue_script('mosaic'); ?>

        jQuery(function($){
            $('.fade').mosaic();
        });
    <?php } ?>
    </script>
<?php }

add_action('wp_head', 'bk_jquery_scripts');

?>