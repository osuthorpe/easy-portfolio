<?php
/*
Template Name: Contact
*/
?>

<?php

$nameError = '';
$emailError = '';
$commentError = '';

if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}

		if(trim($_POST['email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}

		if(trim($_POST['comments']) === '') {
			$commentError = 'Please enter a message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		if(!isset($hasError)) {
			$emailTo = 'osuthorpe@gmail.com';
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option('admin_email');
			}
			$subject = '[Contact Form] From '.$name;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

			mail($emailTo, $subject, $body, $headers);
			$emailSent = true;
		}

} ?>

<?php get_header(); ?>

<div id="main-content">
	<div id="blog-content">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>

				<div class="entry-content">
					<?php if(isset($emailSent) && $emailSent == true) { ?>

                        <div class="thanks">
                            <p><?php _e('Thanks, your email was sent successfully.', 'framework') ?></p>
                        </div>

                    <?php } else { ?>

                        <div class="clear"><?php the_content(); ?></div>

                        <div class="contact-address">
                        	<?php if (rwmb_meta( 'bk_address_contact' )) {
                        		echo '<h5>mailing address</h5>';
                        		echo '<p>'.of_get_option('bk_site_title').'</br>'
                        	      	  .rwmb_meta( 'bk_street_contact' ).'</br>'
                        			  .rwmb_meta( 'bk_city_contact' ).'</br>'
                        			  .rwmb_meta( 'bk_country_contact' ).'</p>';
                        	}

                        	if (rwmb_meta( 'bk_phone_contact' )) {
                        		echo '<h5>phone</h5>';
                        		echo '<p>'.rwmb_meta( 'bk_phone_contact' ).'</p>';
                        	}

                        	if (rwmb_meta( 'bk_email_contact' )) {
                        		echo '<h5>email</h5>';
                        		echo '<p>'.rwmb_meta( 'bk_email_contact' ).'</p>';
                        	} ?>
                        </div>
                        <div class="contact-form">
                        	<h5>Contact Us</h5>
	                        <?php if(isset($hasError) || isset($captchaError)) { ?>
	                            <p class="error"><?php _e('Sorry, an error occured.', 'bk-media') ?><p>
	                        <?php } ?>

	                        <form action="<?php the_permalink(); ?>" id="contactForm" method="post">
	                                <input type="text" name="contactName" placeholder="your name" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
	                                <?php if($nameError != '') { ?>
	                                    <span class="error"><?php echo $nameError; ?></span>
	                                <?php } ?>
	                                <input type="text" name="email" placeholder="your email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
	                                <?php if($emailError != '') { ?>
	                                    <span class="error"><?php echo $emailError; ?></span>
	                                <?php } ?>

	                                <textarea name="comments" placeholder="message" id="commentsText" rows="10" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
	                                <?php if($commentError != '') { ?>
	                                    <span class="error"><?php echo $commentError; ?></span>
	                                <?php } ?>

	                                <input type="hidden" name="submitted" id="submitted" value="true" />
	                                <button class="button" type="submit"><?php _e('Send Email', 'bk-media') ?></button>
	                        </form>
	                    </div>
                    <?php } ?>
				</div><!-- .entry-content -->
			</div><!-- .post -->
		<?php endwhile; endif; ?>
	</div>

	<div id="sidebar">
		<ul><?php get_sidebar(); ?></ul>
	</div>

</div>

</div><!-- Close Wrapper -->

<?php get_footer(); ?>