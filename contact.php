<?php
/*
Template Name: Contact
*/
?>

<?php get_header(); ?>

<?php
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
		$subject = '[PHP Snippets] From '.$name;
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
		$headers = 'From: '.$name.' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}

} ?>
<div id="main-content">
	<div id="blog-content">
		<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>

				<div class="entry-content">
					<?php if(isset($emailSent) && $emailSent == true) { ?>
						<div class="thanks">
							<p>Thanks, your email was sent successfully.</p>
						</div>
					<?php } else { ?>
						<?php the_content(); ?>
						<?php if(isset($hasError) || isset($captchaError)) { ?>
							<p class="error">Sorry, an error occured.<p>
						<?php } ?>

					<form action="<?php the_permalink(); ?>" id="contactForm" method="post">
							<input type="text" name="contactName" placeholder="Your Name" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="required requiredField" />
							<?php if($nameError != '') { ?>
								<span class="error"><?php echo $nameError;?></span>
							<?php } ?>

							<input type="text" name="email" placeholder="Email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="required requiredField email" />
							<?php if($emailError != '') { ?>
								<span class="error"><?php echo $emailError;?></span>
							<?php } ?>

							<textarea name="comments" id="commentsText" placeholder="Message" rows="20" cols="30" class="required requiredField"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
							<?php if($commentError != '') { ?>
								<span class="error"><?php echo $commentError;?></span>
							<?php } ?>

							<input type="submit">

						<input type="hidden" name="submitted" id="submitted" value="true" />
					</form>
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