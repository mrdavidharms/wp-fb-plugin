<?php
/**
 * Plugin Name: My Facebook Tags
 * Description: This plugin adds some Facebook Open Graph tags to our single posts.
 * Version: 1.0.0
 * Author: David Harms
 * Author URI: http://danielpataki.com
 * License: GPL2
 */
 add_action( 'wp_head', 'my_facebook_tags' );
 function my_facebook_tags() {
   if( is_single() ) {
   ?>
     <meta property="og:title" content="<?php the_title() ?>" />
     <meta property="og:site_name" content="<?php bloginfo( 'name' ) ?>" />
     <meta property="og:url" content="<?php the_permalink() ?>" />
     <meta property="og:description" content="<?php the_excerpt() ?>" />
     <meta property="og:type" content="article" />

     <?php
       if ( has_post_thumbnail() ) :
         $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
     ?>
       <meta property="og:image" content="<?php echo $image[0]; ?>"/>
     <?php endif; ?>

   <?php
   }
 }
 add_action( 'publish_post', 'post_published_notification', 10, 2 );
 function post_published_notification( $ID, $post ) {
     $email = get_the_author_meta( 'user_email', $post->post_author );
     $subject = 'Published ' . $post->post_title;
     $message = 'We just published your post: ' . $post->post_title . ' take a look: ' . get_permalink( $ID );
     wp_mail( $email, $subject, $message );
 }
 add_filter('login_errors', 'login_error_message');
 function login_error_message($error){
   $error = "Incorrect login information, stay out";
   return $error;
 }

 add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' );

 function my_enqueued_assets() {
 	wp_enqueue_style( 'my-font', '//fonts.googleapis.com/css?family=Roboto' );
 }

 add_action( 'wp_enqueue_scripts', 'my_enqueued_assets' );

 function my_enqueued_assets() {
 	wp_enqueue_script( 'my-script', plugin_dir_url( __FILE__ ) . '/js/my-script.js', array( 'jquery' ), '1.0', true );
 }
