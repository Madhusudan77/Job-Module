<?php

add_action( 'wp_enqueue_scripts', 'enqueue_media' );
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
    register_taxonomy(
        'services_categories',
        'jobs',
        array(
            'labels' => array(
                'name' => 'Services Categories',
                'add_new_item' => 'Add New Service Category',
                'new_item_name' => "New Service Category"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true,
            'hasArchive' => true
        )
    );
}



//for contractor
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
      $new_user_name = stripcslashes($_POST['new_user_name']);
      $new_user_email = stripcslashes($_POST['new_user_email']);
      $new_user_password = $_POST['new_user_password'];
      $user_nice_name = strtolower($_POST['new_user_email']);
      $user_data = array(
          'user_login' => $new_user_name,
          'user_email' => $new_user_email,
          'user_pass' => $new_user_password,
          'user_nicename' => $user_nice_name,
          'display_name' => $new_user_first_name,
          'role' => 'contractor'
        );
      $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {
          echo'we have Created an account for you.';
        } else {
            if (isset($user_id->errors['empty_user_login'])) {
              $notice_key = 'User Name and Email are mandatory';
              echo $notice_key;
            } elseif (isset($user_id->errors['existing_user_login'])) {
              echo'User name already exixts.';
            } elseif(email_exists($new_user_email)) {
              echo'Email already exixts.';
            } else{
                echo'Error in data';
            }
        }
    die;
}


//for client
add_action('wp_ajax_register_client_user_front_end', 'register_client_user_front_end', 0);
add_action('wp_ajax_nopriv_register_client_user_front_end', 'register_client_user_front_end');
function register_client_user_front_end() {
      $new_cuser_name = stripcslashes($_POST['new_cuser_name']);
      $new_cuser_email = stripcslashes($_POST['new_cuser_email']);
      $new_cuser_password = $_POST['new_cuser_password'];
      $cuser_nice_name = strtolower($_POST['new_cuser_password']);
      $user_data1 = array(
          'user_login' => $new_cuser_name,
          'user_email' => $new_cuser_email,
          'user_pass' => $new_cuser_password,
          'user_nicename' => $cuser_nice_name,
          'display_name' => $new_user_first_name1,
          'role' => 'client'
        );
      $user_id_client = wp_insert_user($user_data1);
        if (!is_wp_error($user_id_client)) {
          echo'we have Created an account for you.';
        } else {
            if (isset($user_id_client->errors['empty_user_login'])) {
              $cnotice_key = 'User Name and Email are mandatory';
              echo $cnotice_key;
            } elseif (isset($user_id_client->errors['existing_user_login'])) {
              echo'User name already exixts.';
            } elseif(email_exists($new_cuser_email)) {
              echo'Email already exixts.';
            } else{
                echo'Error in data';
            }
        }
    die;
}


function ajax_login_init(){

    wp_register_script('ajax-login-script', get_stylesheet_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}
//ajax login form
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


//restricting client from getting to the dashboard
!defined( 'ABSPATH' ) AND exit;
function wpse66093_no_admin_access()
{
    if ( ! is_admin()|| (is_user_logged_in() && isset( $GLOBALS['pagenow'] ) AND 'wp-login.php' === $GLOBALS['pagenow'])) {
        return;
    }

    $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
    if (current_user_can( 'client' ) OR current_user_can( 'client' ))
        exit( wp_redirect( $redirect ) );
}
add_action( 'admin_init', 'wpse66093_no_admin_access', 100 );

