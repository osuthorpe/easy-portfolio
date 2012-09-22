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
        autoplay: false,
        imageCrop: true,

        // set this to false if you want to show the caption all the time:
        _toggleInfo: true,
    },
    init: function(options) {

        Galleria.requires(1.28, 'This version of Classic theme requires Galleria 1.2.8 or later');

        // add some elements
        this.addElement("controls","play","fullscreen","next","previous","count",'info','info-link','info-close'),
        this.append({
            container : "controls",
            controls : ["fullscreen","previous","play","next","count","info"],
            count : 'counter',
            info : ['info-link','info-close']
        });

        // cache some stuff
        var info = this.$('info-link,info-close,info-text'),
            touch = Galleria.TOUCH,
            gallery = this,
            fullscreen = this.$('fullscreen'),
            play = this.$('play'),
            next = this.$('next'),
            previous = this.$('previous'),
            click = touch ? 'touchstart' : 'click';

        // show loader & counter with opacity
        this.$('loader').show().css('opacity', 0.4);

        // some stuff for non-touch browsers
        if (! touch ) {
            this.addIdleState( this.get('counter'), { opacity:1 });

            this.bind("fullscreen_enter", function() {
                fullscreen.addClass('open');
            });

            this.bind("fullscreen_exit", function() {
                fullscreen.removeClass('open');
            });

            this.bind("play", function() {
                play.addClass("playing");
            });

            this.bind("pause", function() {
                play.removeClass('playing');
            });

            fullscreen.click(function() {
                gallery.toggleFullscreen();
            });

            play.click(function() {
                if($('.galleria-play').hasClass('playing')) {
                    gallery.pause();
                } else {
                    gallery.play();
                }
            });

            previous.click(function() {
                gallery.prev();
            });

            next.click(function() {
                gallery.next();
            });

            this.attachKeyboard({
                left: this.prev, // applies the native prev() function
                right: this.next,
                up: this.toggleFullscreen,
            });
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
        })
    }
});

}(jQuery));
