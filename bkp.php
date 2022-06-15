<?php get_header(); ?>




<div class="container">
<?php if (is_user_logged_in()) { ?>
    <a class="login_button" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
<?php } else { ?>
    <a class="login_button" id="show_login" href="">Login</a>
<?php } ?>


<?php if (!is_user_logged_in()) {?>

	<h2 class="header">Register Yourself As A Client or Contractor:</h2>
	<div class="content_area cont_class_field">
            <form action="#" id="resgistration_form" method="POST" name="register-form" class="register-form">
                <fieldset>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="new_user_name" placeholder="Username" id="new-username" required/>
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" name="new_user_email" placeholder="Email address" id="new-useremail" required/>
                    </div>
                    <div class="form-group cont_class">
                        <label for="Businessname">Business Name</label>
                        <input type="text" class="form-control" name="bname" placeholder="Business Name" id="new_bname" required/>
                    </div>
                    <div class="form-group cont_class">
                        <label for="Businessnumber">Business Number</label>
                        <input type="number" class="form-control" name="bnumber" placeholder="Business Number" id="bnumber" required/>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" name="new_user_password" placeholder="Password" id="new-userpassword" required/>
                    </div>
                    <div class="form-group">
                        <label for="RePassword">Re Enter Password</label>
                        <input type="password" class="form-control" name="re-pwd" placeholder="Re-enter Password" id="re-pwd" required/>
                    </div>
                    <div class="form-group">
                        <label for="OTP">Enter OTP</label>
                        <input type="password" class="form-control" name="otp" placeholder="Enter OTP" id="otp" required/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="button" id="register-button" value="Register" >
                    </div>
                    <div class="form-group">
                        <input type="submit" class="button" id="verify-button" value="Verify" >
                    </div>
                    <div id="result_msg_client">
                            
                    </div>
              </fieldset>
            </form>
    </div>
  	<div class="content_area">
		    <form action="#" id="resgistration_form" method="POST" name="register-form" class="register-form">
		      	<fieldset>
					<div class="form-group">
					    <label for="Name">Name</label>
					    <input type="text" class="form-control" name="new_user_name" placeholder="Username" id="new-username" required/>
					</div>
					<div class="form-group">
						<label for="Email">Email</label>
						<input type="email" class="form-control" name="new_user_email" placeholder="Email address" id="new-useremail" required/>
					</div>
					<div class="form-group">
						<label for="Businessname">Business Name</label>
						<input type="text" class="form-control" name="bname" placeholder="Business Name" id="new_bname" required/>
					</div>
					<div class="form-group">
						<label for="Businessnumber">Business Number</label>
						<input type="number" class="form-control" name="bnumber" placeholder="Business Number" id="bnumber" required/>
					</div>
					<div class="form-group">
						<label for="Password">Password</label>
						<input type="password" class="form-control" name="new_user_password" placeholder="Password" id="new-userpassword" required/>
					</div>
					<div class="form-group">
						<label for="RePassword">Re Enter Password</label>
						<input type="password" class="form-control" name="re-pwd" placeholder="Re-enter Password" id="re-pwd" required/>
					</div>
					<div class="form-group">
						<input type="submit" class="button" id="register-button" value="Register" >
					</div>
					<div id="result_msg_client">
							
					</div>
		      </fieldset>
		    </form>
	</div>
		
<?php }?>

<!-- Login form -->
<?php if (!is_user_logged_in()) {?>
<form id="login" action="login" method="post">
        <h1>Site Login</h1>
        <p class="status"></p>
        <label for="username">Username</label>
        <input id="username" type="text" name="username">
        <label for="password">Password</label>
        <input id="password" type="password" name="password">
        <a class="lost" href="<?php echo wp_lostpassword_url(); ?>">Lost your password?</a>
        <input class="submit_button" type="submit" value="Login" name="submit">
        <a class="close" href="">(close)</a>
        <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
    </form>
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
    <script type="text/javascript">
    	
     // for client
    jQuery('#register-button').on('click',function(e){
        e.preventDefault();
        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        var reUserPassword = jQuery('#re-pwd').val();
        var new_bname = jQuery('#new_bname').val();
        var bnumber = jQuery('#bnumber').val();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var valid_email = '';
        var hasError = false;
        if(newUserEmail == '') {
	      	jQuery('#result_msg_client').text('Please enter your email address.').show();
	      	hasError = true;
	    }
	    else if(!emailReg.test(newUserEmail)) {
	      	jQuery('#result_msg_client').text('Enter a valid email address.').show();
	      	hasError = true;
	    }
	    else{
	    	valid_email = newUserEmail;
	    }
		if((newUserName.length>0)&&(valid_email.length>0)&&(newUserPassword.length>0)&&(reUserPassword.length>0)){
        	if(newUserPassword==reUserPassword){
	        	jQuery.ajax({
	                type:"POST",
	                url:"<?php echo admin_url('admin-ajax.php'); ?>",
	                data: {
	                    action: "register_user_front_end",
	                    new_user_name : newUserName,
	                    new_user_email : valid_email,
	                    new_user_password : newUserPassword,
	                    new_bname : new_bname,
	                    bnumber : bnumber
	                },
	                success: function(results){
	                  	if(results.success==true){
							jQuery('#resgistration_form')[0].reset();
						}
						jQuery('#result_msg_client').text(results).show();
	                },
	                error: function(results) {
	        			
	                 	}
	                });
	            }
	            else{
	            	alert('password does not match');
	            }
	        }
	        else{
	        	alert('field is required');
	     	}
      	});

    	
    </script>
<?php get_footer(); ?>


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


