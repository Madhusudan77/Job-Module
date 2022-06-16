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
$labels = array( 
    'name' => __( 'Jobs', 'jobs' ),
    'singular_name' => __( 'Job', 'jobs' ),
    'add_new' => __( 'Add New', 'jobs' ),
    'add_new_item' => __( 'Add New Job', 'jobs' ),
    'edit_item' => __( 'Edit Job', 'jobs' ),
    'new_item' => __( 'New Job', 'jobs' ),
    'view_item' => __( 'View Job', 'jobs' ),
    'search_items' => __( 'Search Jobs', 'jobs' ),
    'not_found' => __( 'No jobs found', 'jobs' ),
    'not_found_in_trash' => __( 'No jobs found in Trash', 'jobs' ),
    'parent_item_colon' => __( 'Parent Job:', 'jobs' ),
    'menu_name' => __( 'Jobs', 'jobs' ),
);

$args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Jobs and Services',
    'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-portfolio',
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capabilities' => array(
        'edit_post' => 'edit_job',
        'edit_posts' => 'edit_jobs',
        'edit_others_posts' => 'edit_other_jobs',
        'publish_posts' => 'publish_jobs',
        'read_post' => 'read_job',
        'read_private_posts' => 'read_private_jobs',
        'delete_post' => 'delete_job'
    ),
    // as pointed out by iEmanuele, adding map_meta_cap will map the meta correctly 
    'map_meta_cap' => true
);

register_post_type( 'jobs', $args );
}

function add_theme_caps() {
    // gets the administrator role
    $admins = get_role( 'administrator' );

    $admins->add_cap( 'edit_job' ); 
    $admins->add_cap( 'edit_jobs' ); 
    $admins->add_cap( 'edit_other_jobs' ); 
    $admins->add_cap( 'publish_jobs' ); 
    $admins->add_cap( 'read_job' ); 
    $admins->add_cap( 'read_private_jobs' ); 
    $admins->add_cap( 'delete_job' ); 
}
add_action( 'admin_init', 'add_theme_caps');



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
    <h2 class="header cont_class" style="display:none;">Register Yourself :</h2>
    <h2 class="header client_class">Register Yourself :</h2>
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


//for contractor and client email sending and job creation
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


//ajax function for new post creation and sending mail
add_action('wp_ajax_create_form_post', 'create_form_post', 0);
add_action('wp_ajax_nopriv_create_form_post', 'create_form_post');
function create_form_post() {

    $jobtitle = $_POST['jobtitle'];
    $jobDesc = $_POST['jobDesc'];
    $jobAmt = $_POST['jobAmt'];
    $payAmt = $_POST['payAmt'];
    $fileName = preg_replace('/\s+/', '-', $_FILES["file"]["name"]);
    $fileName = preg_replace('/[^A-Za-z0-9.\-]/', '', $fileName);
    $fileName = time().'-'.$fileName;
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
    wp_upload_bits($fileName, null, file_get_contents($_FILES["file"]["tmp_name"]));
    update_field('field_62a59d99ee29c', $note_client, $post_id);
    update_field('field_62a59dafee29d', $perNotes, $post_id);
    if($jobtitle==''){
        echo 'Job Title is compulsory';
    }
    else{ 
        echo $thumbnail;

        //mailing part
        $user_ID = get_current_user_id(); 
        $user = new WP_User( $user_ID );
        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
            foreach ( $user->roles as $role ){
                if($role=='client'){
                    $role='contractor';
                }else if($role=='contractor'){
                    $role='client';
                }
                $users = get_users( array( 'role' => $role ) );
                if( ! empty( $users ) ) {
                    $emails = wp_list_pluck( $users, 'user_email' );
                    $to=$emails;
                    $subject='New post';
                    $body = 'New Post is created <b>'.$jobtitle.'</b>';
                    wp_mail($to,$subject,$body);
                }
            }
        }
        
         
    }
    die();
}
//jobs_listing_shortcode
function jobs_listing_shortcode($attr){
    if (is_user_logged_in()) {?>
        <div class='heading_class' ><h2>Jobs</h2></div>
        <?php $user_role = shortcode_atts( array(
            'contractor' => 'contractor_role'
        ), $attr );
        if($user_role['contractor']=='contractor'){?>
            <div class=" content_class contractor_class row  align-items-start" id="job_posts">
        <?php }
        else{?>
            <div class=" content_class row  align-items-start" id="job_posts">
            <?php }?>
        
        
            </div>
        <div id="loading"></div>
    <?php }
}
add_shortcode('jobs_listing_shortcode','jobs_listing_shortcode');

//load more ajax function
add_action('wp_ajax_load_more_action','load_more_action');
add_action('wp_ajax_nopriv_load_more_action','load_more_action');
function load_more_action(){

    $jobs_class = $_POST['jobs_class'];
    
    if($jobs_class=='contractor'){
        $user_ID = get_current_user_id(); 
        $user = new WP_User( $user_ID );
        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
            foreach ( $user->roles as $role ){
                $current_role='contractor';
            }
        }
    }else if($jobs_class=='client'){
        $user_ID = get_current_user_id(); 
        $user = new WP_User( $user_ID );
        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
            foreach ( $user->roles as $role ){
                $current_role='client';
            }
        }
    }else if($jobs_class==''){
        $user_ID = get_current_user_id(); 
        $user = new WP_User( $user_ID );
        if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
            foreach ( $user->roles as $role ){
                $current_role='administrator';
            }
        }
    }

    
    
    $ids = get_users( array('role' => $current_role ,'fields' => 'ID') );
    $args1 = array(
            'post_type' => 'jobs',
            'author' => implode(',', $ids),
            'post_status'=>'publish',
            'paged' => $_POST['page']
        );
        $posts = new WP_Query( $args1 );
    ?>
    <?php if ( $posts->have_posts() ) :?>
            <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

                <div class="content_inner_class col-4">
                    <div class="padded_class">
                        <div class="image_class">
                            <?php $image = get_field('upload_photos');
                            if( !empty( $image ) ){ ?>
                                <div class="img_class" style="background-image: url(<?php echo esc_url($image['url']); ?>);"></div>
                            <?php }
                            else { ?>
                                <div class="img_class" style="background-image: url(<?php echo get_the_post_thumbnail_url(); ?>);"></div>
                            <?php } ?>
                        </div>
                        <a href="<?php echo get_permalink();?>"><?php the_title(); ?></a>
                        <h4><?php echo wp_trim_words( get_the_content(), 10 ); ?></h4>
                        <h4 class="price_class">Price : <span><?php echo get_field('payment_amount'); ?></span></h4>
                        <a class="btn btn-primary" href="<?php echo get_permalink();?>" role="button">View More</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif;
    wp_reset_postdata();

    wp_die();
}


add_action('wp_ajax_accept_ajax_function','accept_ajax_function');
add_action('wp_ajax_nopriv_accept_ajax_function','accept_ajax_function');
function accept_ajax_function(){


    $button_value = $_POST['button_value'];
    $post_id = $_POST['post_id'];
    echo $button_value;
    $post_id = $post_id;
    if($button_value=='Accept'){
        $value = array("accept");
        update_field( "field_62a9c3af758e4", $value, $post_id );
    }else if($button_value=='Decline'){
        $value = array("");
         update_field( "field_62a9c3af758e4", $value, $post_id );
    }
    wp_die();
}
   