<?php
/*
Plugin Name: My Twitter Widget
Plugin URI: http://theme.fm/2011/06/tutorial-creating-a-twitter-widget-for-wordpress-91/
Description: This is the source code of the Creating a Twitter Widget tutorial on Theme.fm
Version: 1.0
Author: Konstantin Kovshenin
Author URI: http://theme.fm
License: GPLv2
*/

class BK_Twitter_Widget extends WP_Widget {
	function __construct() {
		parent::__construct(false, $name = 'BK Media Twitter Widget', array( 'description' => 'Display your latest tweets.' ) );
	}

	/*
	 * Displays the widget form in the admin panel
	 */
	function form( $instance ) {
		$num_tweets = '';
		$title = '';
		$num_tweets = esc_attr( $instance['num_tweets'] );
		$title = esc_attr( $instance['title'] ); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'num_tweets' ); ?>">Number of Tweets:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'num_tweets' ); ?>" name="<?php echo $this->get_field_name( 'num_tweets' ); ?>" type="text" value="<?php echo $num_tweets; ?>" />
		</p>
		<?php }

	/*
	 * Renders the widget in the sidebar
	 */
	function widget( $args, $instance ) {
		echo $args['before_widget'];

		$user = of_get_option('bk_twitter');

		// $json = file_get_contents("http://twitter.com/status/user_timeline/$user.json?count=10", true); //getting the file content
		// $tweets = json_decode($json, true); //getting the file content as array

		// echo '<h2 class="widgettitle">'.$instance['title'].'</h2>';
		// foreach ($tweets as $tweet) {
		// 	echo '<img src="'.$tweet['user']['profile_image_url'].'"/>';
		// 	echo '<p>'.$tweet['text'].'</p>';
		// }

		echo '<h2 class="widgettitle">'.$instance['title'].'</h3>';
		echo '<div id="twitter_update_list">
			<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"> </script>
			<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/'.$user.'.json?callback=twitterCallback2&count='.$instance['num_tweets'].'"></script></div><br />';

		echo $args['after_widget'];
	}
};

// Initialize the widget
add_action( 'widgets_init', create_function( '', 'return register_widget( "BK_Twitter_Widget" );' ) );