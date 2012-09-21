/**
 * Galleria Classic Theme 2012-08-08
 * http://galleria.io
 *
 * Licensed under the MIT license
 * https://raw.github.com/aino/galleria/master/LICENSE
 *
 */

(function($) {

/*global jQuery, Galleria */

Galleria.addTheme({
    name: 'classic',
    author: 'Galleria',
    css: 'galleria.classic.css',
    defaults: {
        transition: 'slide',
        touchTransition: 'slide',
        fullscreenTransition: 'fade',
        thumbnails: false,
        responsive: true,
        autoplay: true,
        imageCrop: true,

        // set this to false if you want to show the caption all the time:
        _toggleInfo: true,
    },
    init: function(options) {

        Galleria.requires(1.28, 'This version of Classic theme requires Galleria 1.2.8 or later');

        // add some elements
        this.addElement("controls","play","fullscreen"),
        this.append({
            container : "controls",
            controls : ["fullscreen", "play"]
        });

        // cache some stuff
        var info = this.$('info-link,info-close,info-text'),
            touch = Galleria.TOUCH,
            gallery = this,
            fullscreen = this.$('fullscreen'),
            click = touch ? 'touchstart' : 'click';

        // show loader & counter with opacity
        this.$('loader,counter').show().css('opacity', 0.4);

        this.bind("fullscreen_enter", function() {
            fullscreen.addClass('open');
        });

        this.bind("fullscreen_exit", function() {
            fullscreen.removeClass('open');
        });

        // some stuff for non-touch browsers
        if (! touch ) {
            this.addIdleState( this.get('image-nav-left'), { left:-50 });
            this.addIdleState( this.get('image-nav-right'), { right:-50 });
            this.addIdleState( this.get('counter'), { opacity:1 });
        }

        // toggle info
        if ( options._toggleInfo === true ) {
            info.bind( click, function() {
                info.toggle();
            });
        } else {
            info.show();
            this.$('info-link, info-close').hide();
        }

        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show().fadeTo(200, 0.4);
            }

            this.$('info').toggle( this.hasInfo() );

            $(e.thumbTarget).css('opacity',1).parent().siblings().children().css('opacity', 0.6);
        });

        this.bind('loadfinish', function(e) {
            this.$('loader').fadeOut(200);
        });

        fullscreen.click(function() {
            gallery.toggleFullscreen();
        })
    }
});

}(jQuery));
