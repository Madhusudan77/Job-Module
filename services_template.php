<?php
/* 
* Template Name: Services Template
*/
get_header()
?>
<div class="container">
	<?php 
		$args1 = array(
		    'post_type' => 'jobs',
		    'paged' => 1
		);
		$posts = new WP_Query( $args1 );
	?>
	<div class="heading_class"><h2>Jobs</h2></div>
	
		<?php if ( $posts->have_posts() ) :?>
			<div class=" content_class row  align-items-start" id="job_posts">
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
	    	
	    	</div>
		<?php endif; ?>
		<button id="more_posts">Load More</button>
	<?php wp_reset_postdata(); ?>
	

	
</div>
<script type="text/javascript">
    jQuery(document).ready(function(e){
    	var page_count = '<?php echo ceil(wp_count_posts('jobs')->publish/2);?>';
        var page = 2;
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
        jQuery('#more_posts').click(function(){
            var data = {
                'action':'load_more_action',
                'page':page
            };
            jQuery.post(ajaxurl, data, function(response){
                jQuery('#job_posts').append(response);
                page++;
                if(page_count==page){
                	jQuery('#more_posts').hide();
                	jQuery('#job_posts').append('<div class="no_more_class">No More jobs</div>');
                }
                
            });
        });
    });
</script>
<?php get_footer(); ?>


