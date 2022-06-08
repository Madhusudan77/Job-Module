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
	<?php dynamic_sidebar( 'sidebar' ); ?>
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
		        			<h5  class="category_name"><span>Location: </span><?php the_field('location'); ?></h5>
		        			<?php $cat_id = get_field('categories');
		        			$term = get_term($cat_id);
		        			?>
		        			<h4 class="category_name"><?php echo '<span>Service: </span>'.$term->name; ?></h4>
		        			<?php if(get_field('price')): ?>
		        				<h4 class="category_name"><span>Price: </span><?php the_field('price'); ?></h4>
		        			<?php endif; ?>
		        			<h4><?php echo wp_trim_words( get_the_content(), 5, '...' );?></h4>
		        			<?php if(get_field('business_name')): ?>
		        				<h4 class="category_name"><span>Business Name: </span><?php the_field('business_name'); ?></h4>
		        			<?php endif; ?>
		        		</div>
		        		<a class="read_more" href="<?php echo get_the_permalink(); ?>"><h5>Read more...</h5></a>
	        		</div>
	        	</div>
	    	<?php endwhile; ?>
		<?php endif; ?>
	<?php wp_reset_postdata(); ?>
	</div>
	

	<ul class="custom_cat_list">
	    <?php $categories = get_categories('taxonomy=services_categories&post_type=jobs'); ?>
	        <?php foreach ($categories as $category) : ?>
	        	<?php $category_id = get_category_link($category->cat_ID); ?>
	            <li><a href="<?php echo $category_id ?>"><?php echo $category->name; ?></a></li>
	    <?php endforeach; ?>
	<ul>
</div>
<?php get_footer(); ?>


<nav>
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Home</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</button>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
</div>