<?php get_header(); ?>
	<div class="container">
        <?php $image = get_field('upload_photos');
        if( !empty( $image ) ){ ?>
            <div class="img_class" style="background-image: url(<?php echo esc_url($image['url']); ?>);"></div>
        <?php }
        else { ?>
        	<div class="image_inner_class">
        		<img src="<?php echo get_the_post_thumbnail_url(); ?>">
        	</div>
        <?php } ?>
    	<a href="<?php echo get_permalink();?>"><?php the_title(); ?></a>
    	<h4><?php echo wp_trim_words( get_the_content(), 10 ); ?></h4>
    	<h4 class="price_class">Price : <span><?php echo get_field('payment_amount'); ?></span></h4>
		
		<div class="select_button_class">
			<?php $value_checked = get_field('checkbox'); ?>
			<?php if($value_checked){?>
				<input type="button" class="accept_btn" id="decline_btn" value="Decline">
			<?php } else{?>
				<input type="button" class="accept_btn" id="accept_btn" value="Accept" >
			<?php } ?>
		</div>
	</div>
<div id="message_show"></div>

	<script type="text/javascript">
		jQuery('.accept_btn').on('click',function(e){
		    e.preventDefault();
		    var button_value = jQuery(this).val();
		    var post_id = "<?php echo get_the_ID();?>";
			jQuery.ajax({
				type:'POST',
		        url:"<?php echo admin_url('admin-ajax.php'); ?>",
		        data: {
		            action: "accept_ajax_function",
		            button_value : button_value,
		            post_id : post_id
		        },
		        success: function(data){
		        	console.log(data);
		        	if(data=='Accept'){
		        		jQuery('#accept_btn').hide();
		        		jQuery('#decline_btn').show();
		        	}else if(data=='Decline'){
		        		jQuery('#accept_btn').show();
		        		jQuery('#decline_btn').hide();
		        	}
		        },
		        error: function(data) {
					
		        }
		    });
        })
	</script>
<?php get_footer(); ?>