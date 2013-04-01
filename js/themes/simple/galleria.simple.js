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
        thumbnails: true,
        responsive: false,
        autoplay: false,
        imageCrop: true,
        carousel: false
    },
    init: function(options) {

        Galleria.requires(1.28, 'Simple theme requires Galleria 1.2.8 or later');

        // add some elements
        this.addElement("controls","play","fullscreen","next","previous","count","info-link","showThumbs","more"),
        this.append({
            container : ["controls","more"],
            controls : ["fullscreen","previous","play","next","count","showThumbs","info-link"],
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
            thumbnails = this.$('thumbnails-container'),
            gallery_back = this.$('container'),
            showThumbs = this.$('showThumbs'),
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
        function thumbSlide() {
	        thumbnails.slideToggle(400,'swing');
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
        
        this.bind("thumbnail", function (e) {
            $(e.thumbTarget).click(function () {
                thumbSlide();
            })
        });
/*
        this.bind("showThumbs", function() {
	        thumbnails.show();
        });
*/

        fullscreen.click(function() {
        	gallery_back.addClass('image-background');
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
        
        showThumbs.click(function() {
        	thumbSlide();
        })

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
                $(e.thumbTarget).css('opacity', 0.8).parent().hover(function() {
                    $(this).not('.active').children().stop().fadeTo(100, 1);
                }, function() {
                    $(this).not('.active').children().stop().fadeTo(400, 0.8);
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
