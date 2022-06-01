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


// add_action('wp_ajax_contact_us_post_submit', 'ajax_contact_us_post_submit');
// function ajax_contact_us_post_submit(){
//     wp_parse_str($_POST['contact_us_post_submit'],$arr);
//     $name = $_POST['name'];
//     $email = $_POST['email'];
//     $phone = $_POST['phone'];
//     $address = $_POST['address'];
//     $bname = $_POST['bname'];
//     $bnumber = $_POST['bnumber'];
//     $cptarr = array(
//         "post_status"=>"published",
//         "post_type"=>"jobs",
//     );
//     $post_data=wp_insert_post($cptarr);
// }



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


function add_your_fields_meta_box() {
        add_meta_box('your_fields_meta_box', 'Your Fields', 'show_your_fields_meta_box', 'jobs', 'normal', 'high' );
    }
add_action( 'add_meta_boxes', 'add_your_fields_meta_box' );


function show_your_fields_meta_box() {
        global $post;
            $meta = get_post_meta( $post->ID, 'your_fields', true ); ?>

        <input type="hidden" name="your_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

        <p>
            <label for="your_fields[name]">Name</label>
            <br>
            <input type="text" name="your_fields[name]" id="your_fields[name]" class="regular-text" value="<?php echo $meta['name']; ?>">
        </p>
        <p>
            <label for="your_fields[email]">Email</label>
            <br>
            <input type="email" name="your_fields[email]" id="your_fields[email]" class="regular-text" value="<?php echo $meta['email']; ?>">
        </p>
        <p>
            <label for="your_fields[phoneno]">Phone number</label>
            <br>
            <input type="tel" name="your_fields[phoneno]" id="your_fields[phoneno]" class="regular-text" value="<?php echo $meta['phoneno']; ?>">
        </p>
        <p>
            <label for="your_fields[textarea]">Address</label>
            <br>
            <textarea name="your_fields[textarea]" id="your_fields[textarea]" rows="5" cols="30" style="width:500px;"><?php echo $meta['textarea']; ?></textarea>
        </p>
        <p>
            <label for="your_fields[bname]">Business Name</label>
            <br>
            <input type="text" name="your_fields[bname]" id="your_fields[bname]" class="regular-text" value="<?php echo $meta['bname']; ?>">
        </p>
        <p>
            <label for="your_fields[bno]">Business number</label>
            <br>
            <input type="tel" name="your_fields[bno]" id="your_fields[bno]" class="regular-text" value="<?php echo $meta['bno']; ?>">
        </p>
    

 <?php }


function save_your_fields_meta( $post_id ) {
        // verify nonce
        if ( !wp_verify_nonce( $_POST['your_meta_box_nonce'], basename(__FILE__) ) ) {
            return $post_id;
        }
        // check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
        // check permissions
        if ( 'page' === $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        $old = get_post_meta( $post_id, 'your_fields', true );
        $new = $_POST['your_fields'];

        if ( $new && $new !== $old ) {
            update_post_meta( $post_id, 'your_fields', $new );
        } elseif ( '' === $new && $old ) {
            delete_post_meta( $post_id, 'your_fields', $old );
        }
    }
    add_action( 'save_post', 'save_your_fields_meta' );