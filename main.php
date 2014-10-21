<?php
/**
* Plugin Name: PDF to Post
* Description: Allows Admin to add a pdf and turns it into a post
* Version: 0.1
* Author: Sam Tobia/Mike Wagner
* License: GPL2
*/

add_action('admin_menu', 'my_plugin_menu');

//Adding the post page
//http://codex.wordpress.org/Function_Reference/add_posts_page
function my_plugin_menu() {
	add_posts_page(
    'My Plugin Posts Page',
    'My Plugin',
    'read',
    'my-unique-identifier',
    'myplugin_form_function'
  );
}
function myplugin_form_function(){
  if(isset($_POST["submit"]) && $_POST["submit"] == "Save Changes"){
    if(!wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' ))
      return myplugin_error("Bad nonce");
    myplugin_handle_upload();
  }else{
    myplugin_form_render();
  }
}

function myplugin_handle_upload(){

}


function myplugin_form_render($error_msg = ""){
  ?>
  <div class="wrap">
  <h2>Your Plugin Page Title</h2>
  <?php
  if($error_msg != ""){
    ?>
    <h3 style="Font-Weight:bold;color:#F00;"><?php echo $error_msg ?></h3>
    <?php
  }
  ?>
  <form method="post" action="<?php get_permalink(); ?>">
  <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
  Upload: <input type="file" name="pdf_file">
  <?php submit_button(); ?>
  </form>
  </div>
  <?php
}

/*
If using an api, need client secret/client key
*/
