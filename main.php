<?php
/**
* Plugin Name: PDF to Post
* Description: Allows Admin to add a pdf and turns it into a post
* Version: 0.1
* Author: Sam Tobia/Mike Wagner
* License: GPL2
*/

add_action('admin_menu', 'pdftowp_post_menu');
add_action( 'admin_init', 'pdftowp_post_redirect_question' );
//Adding the post page
//http://codex.wordpress.org/Function_Reference/add_posts_page
function pdftowp_post_menu() {
	add_posts_page(
    'My Plugin Posts Page',
    'My Plugin',
    'read',
    'my-unique-identifier',
    'pdftowp_post_form_function'
  );
}
function pdftowp_post_form_function(){
    pdftowp_post_form_render();
}

function pdftowp_post_redirect_question(){
	if(!isset($_GET["page"]) || $_GET["page"] !="my-unique-identifier")
		return;
	if(!isset($_POST["submit"]) || $_POST["submit"] != "Save Changes")
		return;
	if(!wp_verify_nonce( $_POST['my_image_upload_nonce'], 'my_image_upload' )){
		global $pdftowp_post_error;
		$pdftowp_post_error ="Bad nonce";
		return;
	}
	pdftowp_post_handle_upload();

}

function pdftowp_post_handle_upload(){
	global $user_ID;
	$myexec = "pdftotext ".$_FILES["pdf_file"]["tmp_name"]." -";
	$stdout = array();
	exec($myexec, $stdout);
	$stdout = implode($stdout, "\n");
	$new_post = array(
		'post_title' => $_POST["pdf_title"],
		'post_content' => $stdout,
		'post_status' => 'publish',
		'post_date' => date('Y-m-d H:i:s'),
		'post_author' => $user_ID,
		'post_type' => 'post'
	);
	$post_id = wp_insert_post($new_post);
//	echo "POST ID: ".$post_id;
//	echo "<br />POST LINK: ".get_edit_post_link($post_id);
//	die();
	header("Location: ".htmlspecialchars_decode(get_edit_post_link($post_id)));
	die();
/* */
}


function pdftowp_post_form_render(){
	global $pdftowp_post_error;
  ?>
  <div class="wrap">
  <h2>Your Plugin Page Title</h2>
  <?php
  if(isset($pdftowp_post_error)){
    ?>
    <h3 style="Font-Weight:bold;color:#F00;"><?php echo $pdftowp_post_error ?></h3>
    <?php
  }
  ?>
  <form method="post" action="<?php get_permalink(); ?>" enctype="multipart/form-data">
  <?php wp_nonce_field( 'my_image_upload', 'my_image_upload_nonce' ); ?>
	Title: <input type="text" name="pdf_title"><br />
  Upload: <input type="file" name="pdf_file">
  <?php submit_button(); ?>
  </form>
  </div>
  <?php
}

/*
If using an api, need client secret/client key
*/
