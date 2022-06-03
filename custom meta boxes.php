<?php 
//adding meta boxes
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