<?php get_header(); ?>

<div class="container">

<?php if (!is_user_logged_in()) {?>
  		
<?php echo do_shortcode('[form_shortcode]'); ?>
		
<?php }?>

<?php if (is_user_logged_in()) {?>
	<div class="modal_display">
		<h3 class="header_job">Register a service</h3>
		<?php
		acf_form_head();
		acf_form(array(
			'post_id'		=> 'new_post',
			'post_title'	=> true,
			'post_content'	=> true,
			'new_post'		=> array(
				'post_type'		=> 'jobs',
				'post_status'	=> 'publish'
			)
		));?>
	</div>
	
<?php }?>
</div>

<?php get_footer(); ?>