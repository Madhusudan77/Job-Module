<?php


function enqueue_media() {
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/widget-js.js', array(), '1.0.0', true );
    wp_enqueue_script('media-upload');
    wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.4.1.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
    wp_enqueue_media();

}
add_action( 'wp_enqueue_scripts', 'enqueue_media' );


add_action( 'wp_enqueue_scripts', 'my_plugin_add_stylesheet' );
function my_plugin_add_stylesheet() {
    wp_enqueue_style( 'my-style', get_stylesheet_directory_uri() . '/style.css', false, '1.0', 'all' );
}



//Add a custom user role

$result = add_role( 'client', __('Client' ), array(
    'read' => true, 
    'edit_posts' => true,
    'edit_pages' => true, 
    'edit_others_posts' => true, 
    'create_posts' => true, 
    'manage_categories' => true, 
    'publish_posts' => true,
    'edit_themes' => false,
    'install_plugins' => false, 
    'update_plugin' => false,
    'update_core' => false 
) );

$result = add_role( 'contractor', __('Contractor' ), array(
    'read' => true, 
    'edit_posts' => true,
    'edit_pages' => true, 
    'edit_others_posts' => true, 
    'create_posts' => true, 
    'manage_categories' => true, 
    'publish_posts' => true,
    'edit_themes' => false,
    'install_plugins' => false, 
    'update_plugin' => false,
    'update_core' => false 
) );




// //saving form data into database client
// add_action('wp_ajax_contact_us', 'ajax_contact_us');
// function ajax_contact_us(){
//     $arr=[];
//     wp_parse_str($_POST['contact_us'],$arr);
//     global $wpdb;
//     global $table_prefix;
//     $table = $table_prefix.'contact_us';
//     $result = $wpdb->insert($table,[
//         "name" => $arr['name'],
//         "email" => $arr['email'],
//         "phone" => $arr['phone'],
//         "address" => $arr['address']
//     ]);
//     if($result>0){
//         wp_send_json_success("Data inserted");
//     }else{
//         wp_send_json_error("Please try again");
//     }
// }


// //saving form data into database contractor
// add_action('wp_ajax_contact_us_contractor', 'ajax_contact_us_contractor');
// function ajax_contact_us_contractor(){
//     $arr=[];
//     wp_parse_str($_POST['contact_us_contractor'],$arr);
//     global $wpdb;
//     global $table_prefix;
//     $table = $table_prefix.'contact_us_contractor';
//     $result = $wpdb->insert($table,[
//         "name" => $arr['name'],
//         "email" => $arr['email'],
//         "phone" => $arr['phone'],
//         "address" => $arr['address'],
//         "bname" => $arr['bname'],
//         "bnumber" => $arr['bnumber']
//     ]);
//     if($result>0){
//         wp_send_json_success("Data inserted");
//     }else{
//         wp_send_json_error("Please try again");
//     }
// }


//custom post type job module
add_action( 'init', 'job_module' );
function job_module ()
{
    register_post_type( 'jobs',
        array(
            'labels' => array(
                'name' => __( 'Jobs' ),
                'singular_name' => __( 'Job' )
            ),
        'public' => true,
        'supports' => array ('title', 'editor', 'thumbnail')
        )
    );
}


// add_action('wp_ajax_contact_us_post_submit', 'ajax_contact_us_post_submit');
// function ajax_contact_us_post_submit(){
//     $arr=[];
//     wp_parse_str($_POST['contact_us_post_submit'],$arr);
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $phone = $_POST['phone'];
//     $address = $_POST['address'];
//     $bname = $_POST['bname'];
//     $bnumber = $_POST['bnumber'];
//     $post_data = array(
//         'post_title'    => $_POST['post_title'],
//         'post_type'     => 'jobs',
//         'post_status'   => 'publish'
//     );
//     $post_id = wp_insert_post( $post_data );


//     $field_key = "email";
//     $value = $email;
//     update_field( $field_key, $value, $post_id );

//     $field_key = "phone_no";
//     $value = $phone;
//     update_field( $field_key, $value, $post_id );

//     $field_key = "business_name";
//     $value = $bname;
//     update_field( $field_key, $value, $post_id );

//     $field_key = "business_number";
//     $value = $bnumber;
//     update_field( $field_key, $value, $post_id );
// }



//login form
function ajax_login_init(){

    wp_register_script('ajax-login-script', get_stylesheet_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}


//ajax call
function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}



// registration form
function vb_registration_form() { ?>
 
<div class="vb-registration-form">
  <form class="form-horizontal registraion-form" role="form">
 
    <div class="form-group">
      <label for="vb_name" class="sr-only">Your Name</label>
      <input type="text" name="vb_name" id="vb_name" value="" placeholder="Your Name" class="form-control" />
    </div>
 
    <div class="form-group">
      <label for="vb_email" class="sr-only">Your Email</label>
      <input type="email" name="vb_email" id="vb_email" value="" placeholder="Your Email" class="form-control" />
    </div>
 
    <div class="form-group">
      <label for="vb_nick" class="sr-only">Your Nickname</label>
      <input type="text" name="vb_nick" id="vb_nick" value="" placeholder="Your Nickname" class="form-control" />
    </div>
 
    <div class="form-group">
      <label for="vb_username" class="sr-only">Choose Username</label>
      <input type="text" name="vb_username" id="vb_username" value="" placeholder="Choose Username" class="form-control" />
      <span class="help-block">Please use only a-z,A-Z,0-9,dash and underscores, minimum 5 characters</span>
    </div>
 
    <div class="form-group">
      <label for="vb_pass" class="sr-only">Choose Password</label>
      <input type="password" name="vb_pass" id="vb_pass" value="" placeholder="Choose Password" class="form-control" />
      <span class="help-block">Minimum 8 characters</span>
    </div>
 
    <?php wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true ); ?>
 
    <input type="submit" class="btn btn-primary" id="btn-new-user" value="Register" />
  </form>
 
    <div class="indicator">Please wait...</div>
    <div class="alert result-message"></div>
</div>
 
<?php
}
add_shortcode('vb_registration_form', 'vb_registration_form');


wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true );


function vb_register_user_scripts() {
  // Enqueue script
  wp_register_script('vb_reg_script', get_stylesheet_directory_uri() . '/ajax-registration.js', array('jquery'), null, false);
  wp_enqueue_script('vb_reg_script');
 
  wp_localize_script( 'vb_reg_script', 'vb_reg_vars', array(
        'vb_ajax_url' => admin_url( 'admin-ajax.php' ),
      )
  );
}
add_action('wp_enqueue_scripts', 'vb_register_user_scripts', 100);


//New User registration
function vb_reg_new_user() {
  // Verify nonce
  if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ) )
    die( 'Ooops, something went wrong, please try again later.' );
 
  // Post values
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $email    = $_POST['mail'];
    $name     = $_POST['name'];
    $nick     = $_POST['nick'];

    $userdata = array(
        'user_login' => $username,
        'user_pass'  => $password,
        'user_email' => $email,
        'first_name' => $name,
        'nickname'   => $nick,
    );
 
    $user_id = wp_insert_user( $userdata ) ;
 
    // Return
    if( !is_wp_error($user_id) ) {
        echo '1';
    } else {
        echo $user_id->get_error_message();
    }
  die();
 
}
 
add_action('wp_ajax_register_user', 'vb_reg_new_user');
add_action('wp_ajax_nopriv_register_user', 'vb_reg_new_user');