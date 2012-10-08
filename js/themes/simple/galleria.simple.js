/**
 * Galleria Simple Theme
 * http://www.alexthorpe.com
 *
 * Licensed under GPL2
 *
 */

(function($) {

/*global jQuery, Galleria */
Galleria.addTheme({
    name: 'simple',
    author: 'Galleria',
    css: 'galleria.simple.css',
    defaults: {
        transition: 'fade',
        touchTransition: 'slide',
        fullscreenTransition: 'fade',
        fullscreenCrop: true,
        thumbnails: false,
        responsive: false,
        autoplay: false,
        imageCrop: true
    },
    init: function(options) {

        Galleria.requires(1.28, 'This version of Classic theme requires Galleria 1.2.8 or later');

        // add some elements
        this.addElement("controls","play","fullscreen","next","previous","count",'info-link','more'),
        this.append({
            container : ["controls","more"],
            controls : ["fullscreen","previous","play","next","count","info-link"],
            count : 'counter'
        });

        // cache some stuff
        var info = this.$('info-link'),
            more = this.$('more'),
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
            this.attachKeyboard({
                left: this.prev, // applies the native prev() function
                right: this.next,
                up: this.toggleFullscreen,
            });
        }

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

        info.click(function() {
            $('.galleria-more').toggle();
        });

        more.click(function() {
            $('.galleria-more').hide();
        });

        // bind some stuff
        this.bind('thumbnail', function(e) {

            if (! touch ) {
                // fade thumbnails
                $(e.thumbTarget).css('opacity', 0.6).parent().hover(function() {
                    $(this).not('.active').children().stop().fadeTo(100, 1);
                }, function() {
                    $(this).not('.active').children().stop().fadeTo(400, 0.6);
                });

                if ( e.index === this.getIndex() ) {
                    $(e.thumbTarget).css('opacity',1);
                }
            } else {
                $(e.thumbTarget).css('opacity', this.getIndex() ? 1 : 0.6);
            }
        });

        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show().fadeTo(200, 0.4);
            }

            var imgData = this.getData(),
                desc = "<strong>" + imgData.title + "</strong>" + "<p>" + imgData.description + "</p>";

            $(".galleria-more").html(desc);

            $(e.thumbTarget).css('opacity',1).parent().siblings().children().css('opacity', 0.6);
        });

        this.bind('loadfinish', function(e) {
            this.$('loader').fadeOut(200);
        })
    }
});

}(jQuery));
