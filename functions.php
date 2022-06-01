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


add_action('wp_ajax_contact_us', 'ajax_contact_us');
function ajax_contact_us(){
    $arr=[];
    wp_parse_str($_POST['contact_us'],$arr);
    global $wpdb;
    global $table_prefix;
    $table = $table_prefix.'contact_us';
    $result = $wpdb->insert($table,[
        "name" => $arr['name'],
        "email" => $arr['email'],
        "phone" => $arr['phone'],
        "address" => $arr['address']
    ]);
    if($result>0){
        wp_send_json_success("Data inserted");
    }else{
        wp_send_json_error("Please try again");
    }
}

add_action('wp_ajax_contact_us_contractor', 'ajax_contact_us_contractor');
function ajax_contact_us_contractor(){
    $arr=[];
    wp_parse_str($_POST['contact_us_contractor'],$arr);
    global $wpdb;
    global $table_prefix;
    $table = $table_prefix.'contact_us_contractor';
    $result = $wpdb->insert($table,[
        "name" => $arr['name'],
        "email" => $arr['email'],
        "phone" => $arr['phone'],
        "address" => $arr['address'],
        "bname" => $arr['bname'],
        "bnumber" => $arr['bnumber']
    ]);
    if($result>0){
        wp_send_json_success("Data inserted");
    }else{
        wp_send_json_error("Please try again");
    }
}



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