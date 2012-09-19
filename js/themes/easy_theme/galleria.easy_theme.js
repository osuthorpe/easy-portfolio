Galleria.addTheme({
    name: 'my theme',
    author: 'John Doe, http://example.com',
    version: 1,
    css: 'galleria.easy_theme.css',
    defaults: {
        // add your own default options here
        transition: 'fade',
        imagecrop: true,

        // custom theme-specific options should begin with underscore:
        _my_color: 'yellow'
    },
    init: function(options) {

        /*
        The init function get's called when galleria is ready.
        You have access to all public methods and events in here
        this = gallery instance
        options = gallery options (including custom options)
        */

        // set the container's background to the theme-specific _my_color option:
        this.$('#galleria').css('background-color', options._my_color);

        // bind a loader animation:
        this.bind('loadstart', function(e) {
            if (!e.cached) {
                this.$('loader').show();
            }
        });
        this.bind('loadfinish', function(e) {
            this.$('loader').hide();
        });
    }
});