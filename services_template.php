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
							<?php $thumb = get_the_post_thumbnail_url(); ?>
							<a href="<?php echo get_the_permalink(); ?>"><div class="image-class" style="background-image: url('<?php echo $thumb;?>')"></div></a>
						</div>
		        		<div class="title_class">
		        			<a href="<?php echo get_the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
		        			<h4><?php echo wp_trim_words( get_the_content(), 10, '...' );?></h4>
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
	
	<?php 
	$wcatTerms = get_terms('services_categories', array('hide_empty' => 0, 'order' =>'asc', 'parent' =>0));
        foreach($wcatTerms as $wcatTerm) : ?>
            <small><a href="<?php echo get_term_link( $wcatTerm->slug, $wcatTerm->taxonomy ); ?>"><?php echo $wcatTerm->name; ?></a></small>
            <?php
            $args = array(
                'post_type' => 'jobs',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'services_categories',
                        'field' => 'slug',
                        'terms' => $wcatTerm->slug,
                    )
                ),
                'posts_per_page' => 1
            );
            $loop = new WP_Query( $args );?>
            <nav>
  				<div class="nav nav-tabs" id="nav-tab" role="tablist">
		            <?php while ( $loop->have_posts() ) : $loop->the_post();?>
		            	<?php $title=get_the_title($post->ID);?>
		      			<button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"><?php the_title(); ?></button>
		    		<?php endwhile; wp_reset_postdata(); ?> 
		    	</div>
			</nav>
     	<?php endforeach;  ?>
</div>
<?php get_footer(); ?>


<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
</div>