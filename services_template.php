<?php
/* 
* Template Name: Services Template
*/
get_header()
?>
<div class="container">
		
	<?php echo do_shortcode('[jobs_listing_shortcode contractor="contractor"]'); ?>
</div>
<?php get_footer(); ?>