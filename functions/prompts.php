<?php
add_action( 'admin_enqueue_scripts', 'my_admin_enqueue_scripts' );
function my_admin_enqueue_scripts() {
    wp_enqueue_style( 'wp-pointer' );
    wp_enqueue_script( 'wp-pointer' );
    add_action( 'admin_print_footer_scripts', 'my_admin_print_footer_scripts' );
}
function my_admin_print_footer_scripts() {
    $pointer_content = '<h3>iShift | Notice</h3>';
    $pointer_content .= '<p>Added new functions to Edit Post section and few more options for users (authors and subscribers only).</p>';
?>
   <script type="text/javascript">
   //<![CDATA[
   jQuery(document).ready( function($) {
    $('#menu-appearance').pointer({
        content: '<?php echo $pointer_content; ?>',
        position: 'top',
        close: function() {
            // Once the close button is hit
        }
      }).pointer('open');
   });
   //]]>
   </script>
<?php
}