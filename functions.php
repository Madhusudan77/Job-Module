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

function form_shortcode(){
    $string='
    <h2 class="header cont_class" style="display:none;">Register Yourself As A Contractor:</h2>
    <h2 class="header client_class">Register Yourself As A Client:</h2>
    <div class="content_area cont_class_field">
            <form action="#" id="resgistration_form" method="POST" name="register-form" class="register-form">
                <fieldset>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="new_user_name" placeholder="Username" id="new-username" required/>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="new_user_email" placeholder="Email address" id="new-useremail" required/>
                    </div>
                    <div class="form-group cont_class">
                        <label for="Businessname">Business Name</label>
                        <input type="text" class="form-control" name="bname" placeholder="Business Name" id="new_bname" required/>
                    </div>
                    <div class="form-group cont_class">
                        <label for="Businessnumber">Business Number</label>
                        <input type="number" class="form-control" name="bnumber" placeholder="Business Number" id="bnumber" required/>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" name="new_user_password" placeholder="Password" id="new-userpassword" required/>
                    </div>
                    <div class="form-group">
                        <label for="RePassword">Re Enter Password</label>
                        <input type="password" class="form-control" name="re-pwd" placeholder="Re-enter Password" id="re-pwd" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="button" id="register-button" value="Register" >
                    </div>
                    <div id="result_msg_client">
                            
                    </div>
              </fieldset>
            </form>
    </div>';
    return $string;
}
add_shortcode('form_shortcode', 'form_shortcode');


//for contractor
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {
    $new_user_name = stripcslashes($_POST['new_user_name']);
    $new_user_email = stripcslashes($_POST['new_user_email']);
    $new_user_password = $_POST['new_user_password'];
    $number = $_POST['number'];
    $new_user_name = $new_user_name.$number;
    $user_nice_name = strtolower($_POST['new_user_email']);
    $new_bname = stripcslashes($_POST['new_bname']);
    $bnumber = stripcslashes($_POST['bnumber']);
    $business_code = $_POST['business_code'];
    if ($business_code == 'business_code') {
        $user_data = array(
            'user_login' => $new_user_name,
            'user_email' => $new_user_email,
            'user_pass' => $new_user_password,
            'user_nicename' => $user_nice_name,
            'display_name' => $new_user_first_name,
            'new_bname' => $new_bname,
            'bnumber' => $bnumber,
            'role' => 'contractor'
        );
    }else{
        $user_data = array(
            'user_login' => $new_user_name,
            'user_email' => $new_user_email,
            'user_pass' => $new_user_password,
            'user_nicename' => $user_nice_name,
            'display_name' => $new_user_first_name,
            'role' => 'client'
        );
    }
      
      $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {
            $to = $new_user_email;
            $subject = 'The subject';
            $body = 'The User Name is <b>'.$new_user_name.'<b> and Password is <b> '.$new_user_password.'</b>';
            wp_mail( $to, $subject, $body );
            echo'Your new Username and Password is send to your email.';
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



// add our widget locations
function ourWidget(){
    register_sidebar(array(
     'name' => 'Sidebar',
     'id' => 'sidebar'
    ));
}
add_action('widgets_init', 'ourWidget');


add_action( 'user_new_form', 'crf_admin_registration_form' );
function crf_admin_registration_form( $operation ) {
    if ( 'add-new-user' !== $operation ) {
        // $operation may also be 'add-existing-user'
        return;
    }

    $year = ! empty( $_POST['year_of_birth'] ) ? intval( $_POST['year_of_birth'] ) : '';

    ?>
    <h3><?php esc_html_e( 'Personal Information', 'crf' ); ?></h3>

    <table class="form-table">
        <tr>
            <th><label for="year_of_birth"><?php esc_html_e( 'Year of birth', 'crf' ); ?></label> <span class="description"><?php esc_html_e( '(required)', 'crf' ); ?></span></th>
            <td>
                <input type="number"
                   min="1900"
                   max="2017"
                   step="1"
                   id="year_of_birth"
                   name="year_of_birth"
                   value="<?php echo esc_attr( $year ); ?>"
                   class="regular-text"
                />
            </td>
        </tr>
    </table>
    <?php
}