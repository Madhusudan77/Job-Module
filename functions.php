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
//user_registration_form_shortcode
function user_registration_form_shortcode($attr){
    $user_role = shortcode_atts( array(
            'contractor' => 'contractor_role'
        ), $attr );
    
    if($user_role['contractor']=='contractor'){
        $business_div='<div class="form-group cont_class">
                        <label for="Businessname">Business Name</label>
                        <input type="text" class="form-control" name="bname" placeholder="Business Name" id="new_bname" required/>
                        <div class="businessname_error error_class"></div>
                    </div>
                    <div class="form-group cont_class">
                        <label for="Businessnumber">Business Number</label>
                        <input type="number" class="form-control" name="bnumber" placeholder="Business Number" id="bnumber" required/>
                        <div class="businessno_error error_class"></div>
                    </div>';
    }
    else{
        $business_div='';
    }
    if (!is_user_logged_in()){
    $string='
    <h2 class="header cont_class" style="display:none;">Register Yourself As A Contractor:</h2>
    <h2 class="header client_class">Register Yourself As A Client:</h2>
    <div class="content_area cont_class_field">
            <form action="#" id="resgistration_form" method="POST" name="register-form" class="register-form">
                    <div id="result_msg_client" class="error_class">
                            
                    </div>
                <fieldset>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="new_user_name" placeholder="Username" id="new-username" required/>
                        <div class="username_error error_class"></div>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="new_user_email" placeholder="Email address" id="new-useremail" required/>
                        <div class="email_error error_class"></div>
                    </div>
                    '.$business_div.'
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" name="new_user_password" placeholder="Password" id="new-userpassword" required/>
                        <div class="password_error error_class"></div>
                    </div>
                    <div class="form-group">
                        <label for="RePassword">Re Enter Password</label>
                        <input type="password" class="form-control" name="re-pwd" placeholder="Re-enter Password" id="re-pwd" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="button" id="register-button" value="Register" >
                    </div>
                    
                </fieldset>
            </form>
    </div>';
    return $string;
}   ?>

<?php }
add_shortcode('user_registration_form_shortcode', 'user_registration_form_shortcode');


//for contractor
add_action('wp_ajax_register_user_front_end', 'register_user_front_end', 0);
add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end');
function register_user_front_end() {

    $new_user_name = stripcslashes($_POST['new_user_name']);
    $new_user_email = stripcslashes($_POST['new_user_email']);
    $new_user_password = $_POST['new_user_password'];
    $number = $_POST['number'];
    $user_nice_name = strtolower($_POST['new_user_email']);
    $new_bname = stripcslashes($_POST['new_bname']);
    $bnumber = stripcslashes($_POST['bnumber']);
    if($bnumber==''){
        $user_data = array(
        'user_login' => $new_user_name,
        'user_email' => $new_user_email,
        'user_pass' => $new_user_password,
        'user_nicename' => $user_nice_name,
        'display_name' => $new_user_first_name,
        'new_bname' => $new_bname,
        'bnumber' => $bnumber,
        'role' => 'client'
    );
    }else{
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
}
      $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {

            // get user data
            $user_info = get_userdata($user_id);
            $code = md5(time());
            $subject = 'Email verification Link'; 
            $string = array('id'=>$user_id, 'code'=>$code);
            update_user_meta($user_id, 'account_activated', 0);
            update_user_meta($user_id, 'activation_code', $code);
            $url = get_site_url(). '/?act=' .base64_encode( serialize($string));
            $html = 'Please click the following links to verify <br/><br/> <a href="'.$url.'">'.$url.'</a>';
            wp_mail( $user_info->user_email, $subject , $html);
            echo'Your new Username and Password is send to your email.';
        } else {
            if (isset($user_id->errors['empty_user_login'])) {
              $notice_key = 'Userame and Email are mandatory';
              echo $notice_key;
            } elseif (isset($user_id->errors['existing_user_login'])) {
              echo'Username already taken.';
            } elseif(email_exists($new_user_email)) {
              echo'Email already exixts.';
            } else{
                echo'Error in data';
            }
        }
    die;
}
add_action( 'init', 'verify_user_code' );
function verify_user_code( $value ){
    if(isset($_GET['act'])){
        $data = unserialize(base64_decode($_GET['act']));
        $code = get_user_meta($data['id'], 'activation_code', true);
        // verify whether the code given is the same as ours
        if($code == $data['code']){
            // update the user meta
            update_user_meta($data['id'], 'is_activated', 1);
            
            echo "Verified User";

        }
    }
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

    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    
    $user_pass = get_user_by('login', $_POST['password']);
    $user_data = get_user_by('login', $_POST['username']);
    $login_user_id = $user_data->ID;
    $key = 'is_activated'; 
    $single = true; 
    $user_last = get_user_meta( $login_user_id, $key, $single ); 
    if($user_data){
        if($user_last==1){
            $user_signon = wp_signon( $info, false );
            if ( is_wp_error($user_signon) ){
                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
            } else {
                echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
            }
        }
        else if($user_last==0){
            if($user_pass){
                echo json_encode(array('loggedin'=>false, 'message'=>__('Verify your email first')));
            }
            else{
                echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
            }
        }
    }
    else{
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    }
    die();
}



add_action('wp_ajax_create_form_post', 'create_form_post', 0);
add_action('wp_ajax_nopriv_create_form_post', 'create_form_post');
function create_form_post() {

    $jobtitle = $_POST['jobtitle'];
    $jobDesc = $_POST['jobDesc'];
    $jobAmt = $_POST['jobAmt'];
    $payAmt = $_POST['payAmt'];
    $thumbnail = $_POST['thumbnail'];
    $note_client = $_POST['note_client'];
    $perNotes = $_POST['perNotes'];
    $post_id = wp_insert_post(array (
       'post_type' => 'jobs',
       'post_title' => $jobtitle,
       'post_content' => $jobDesc,
       'post_status' => 'publish',
       'comment_status' => 'closed',   // if you prefer
       'ping_status' => 'closed',      // if you prefer
    ));
    update_field('field_62a59ce3ee299', $jobAmt, $post_id);
    update_field('field_62a59d36ee29a', $payAmt, $post_id);
    update_field('field_62a59d70ee29b', $thumbnail, $post_id);
    update_field('field_62a59d99ee29c', $note_client, $post_id);
    update_field('field_62a59dafee29d', $perNotes, $post_id);
    if($jobtitle==''){
        echo 'Job Title is compulsory';
    }
    else{ 
        echo'New Post Created.';
        $users = get_users( array( 'role' => 'client' ) );
        foreach ( $users as $user ) { 
            $email = get_user_meta($user->ID, "email", true);
            $to=$email;
            $subject='New post';
            $body = 'Testing';
            wp_mail($to,$subject,$body);
        }
        $users = get_users();
        foreach ($users as $user ) { 
            if ( in_array( 'client', (array) $user->roles ) ) {
                $email = get_user_meta($user->ID, "email", true);
                $to=$email;
                $subject='New post';
                $body = 'Testing';
                wp_mail($to,$subject,$body);
            }
        }
         
    }
    die();
}