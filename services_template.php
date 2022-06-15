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
	
			<div class=" content_class row  align-items-start" id="job_posts">
			
	    	
	    	</div>
	    	<div id="loading"></div>
	<?php wp_reset_postdata(); ?>
	
</div>
<script type="text/javascript">
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var page_count = '<?php echo ceil(wp_count_posts('jobs')->publish/2);?>';
    var page = 1;
    jQuery(document).ready(function(){
    	jQuery('#loading').html('<p><img src="http://localhost/services/wp-content/uploads/2022/06/ajax-loader.gif"></p>');
        var data = {
            'action':'load_more_action',
            'page':page
        };
        jQuery.post(ajaxurl, data, function(response){
            jQuery('#job_posts').append(response);
            page++;
            if(page_count==page){
            	jQuery('#loading').hide();
            	jQuery('#job_posts').append('<div class="no_more_class">No More jobs</div>');
            }
            else{
		    	jQuery(window).scroll(function(){
		    		if(jQuery(window).scrollTop()==jQuery(document).height()-jQuery(window).height()){
		    			jQuery('#loading').html('<p><img src="http://localhost/services/wp-content/uploads/2022/06/ajax-loader.gif"></p>');
		    			if(!(page_count==page)){
				            var data = {
					            'action':'load_more_action',
					            'page':page
					        };
       				 		jQuery.post(ajaxurl, data, function(response){
            					jQuery('#job_posts').append(response);
					            page++;
					            if(page_count==page){
					            	jQuery('#loading').hide();
					            	jQuery('#job_posts').append('<div class="no_more_class">No More jobs</div>');
					            }
					        });
       				 	}
		    		}else{
		    			jQuery('#loading').empty();	
		    		}
		    	});
		    }
            
        });
    });
    
</script>
<?php get_footer(); ?>