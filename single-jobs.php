<?php get_header(); ?>
	<div class="container">
		<?php if(!(get_field('notified'))){ ?>
			<div class="message_box">
				<div class="alert alert-warning alert-dismissible" id="alert_message">
	                <a href="#" class="close" id="accept_close" data-dismiss="alert" aria-label="close">&times;</a>
	                <div class="message_box_text">
	                	<?php //$field_value = get_field('checkbox');
						if( in_array( "accept", get_field( 'checkbox' ) ) ) {
							$show_value = 'accepted';
							echo 'Job Accepted';
						}else{
							$show_value = 'declined';
							echo 'This is a notification for accept or decline';
						}?>
	                </div>
	            </div>
			</div>
		<?php }?>


		<?php //$field_value = get_field('checkbox');
		if( in_array( "accept", get_field( 'checkbox' ) ) ) {
			$show_value = 'accepted';?>
			<div class="show_condition"><?php echo 'Accepted';?></div>
		<?php }else{?>
			<?php $show_value = 'declined';?>
			<div class="show_condition"><?php echo 'Declined';?></div>
		<?php }?>
		<div class="select_button_class">
			<input type="button" class="accept_btn" id="decline_btn" value="Decline">
			<input type="button" class="accept_btn" id="accept_btn" value="Accept" >
		</div>
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
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function(){

			jQuery('#accept_close').on('click',function(e){
			    e.preventDefault();
			    var post_id = "<?php echo get_the_ID();?>";
				jQuery.ajax({
					type:'POST',
			        url:"<?php echo admin_url('admin-ajax.php'); ?>",
			        data: {
			            action: "accept_popup_function",
			            post_id : post_id
			        },
			        success: function(data){
			        	console.log(data);
			        },
			        error: function(data) {
						
			        }
			    });
		    });
			jQuery('.accept_btn').on('click',function(e){

			    e.preventDefault();
			    jQuery('#success-alert').remove();
			    jQuery('#unsuccess-alert').hide();
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
			        dataType: 'json',
			        success: function(data){
			        	console.log(data[1]);
			        	jQuery('.message_box').html(data[1]);
			        	if(data[0]=='Accept'){
			        		jQuery('.show_condition').text("Job Accepted");
			        		jQuery('.message_box_text').html('Job Accepted');
			        	}else if(data[0]=='Decline'){
			        		jQuery('.show_condition').text("Job Declined");
			        		jQuery('.message_box_text').html('Job Declined');
			        	}
			        },
			        error: function(data) {
						
			        }
			    });
		    });
		});
	</script>
<?php get_footer(); ?>