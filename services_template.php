<?php
/* 
* Template Name: Services Template
*/
get_header()
?>
<div class="container">
	<?php 
		$args = array(
		    'post_type' => 'jobs',
		    'post_status' => 'publish',
		    'posts_per_page' => -1
		);
		$posts = new WP_Query( $args );
	?>

<div class=" content_class row">
	<?php if ( $posts->have_posts() ) :
		while ( $posts->have_posts() ) : $posts->the_post(); ?>
			<div class="container_class col-sm-3 box">
				<div class="inner_class">
					<div class="image_class">
						<?php the_post_thumbnail(); ?>
					</div>
	        		<div class="title_class">
	        			<a href="<?php echo get_the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
	        			<h4><?php the_content(); ?></h4>
	        			<?php if(get_field('price')): ?>
	        				<h4>Price: <?php the_field('price'); ?></h4>
	        			<?php endif; ?>
	        			<?php if(get_field('business_name')): ?>
	        				<h4>Business Name: <?php the_field('business_name'); ?></h4>
	        			<?php endif; ?>
	        		</div>
	        		<a class="read_more" href="<?php echo get_the_permalink(); ?>"><h5>Read more...</h5></a>
        		</div>
        	</div>
    	<?php endwhile; ?>
	<?php endif; ?>
<?php wp_reset_postdata(); ?>
</div>
</div>
<?php get_footer(); ?>