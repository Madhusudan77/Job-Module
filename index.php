<?php get_header(); ?>




<div class="container">
<?php if (is_user_logged_in()) { ?>
    <a class="login_button" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
<?php } else { ?>
    <a class="login_button" id="show_login" href="">Login</a>
<?php } ?>


<?php if (!is_user_logged_in()) {?>

	<h2 class="header">Register Yourself As A Client or Contractor:</h2>
	<ul class="nav nav-tabs">
    	<li class="active"><a data-toggle="tab" href="#home">Contractor</a></li>
    	<li><a data-toggle="tab" href="#menu1">Client</a></li>
  	</ul>
  	<div class="tab-content">
  		<div id="home" class="tab-pane fade in active">
  			<!-- Contractor Form -->
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
		<!-- Client Form -->
		<div id="menu1" class="tab-pane fade">
			<form action="#" id="resgistration_form_client" method="POST" name="register-form" class="cregister-form">
		      	<fieldset>
					<div class="form-group">
					    <label for="Name">Name</label>
					    <input type="text" class="form-control" name="new_cuser_name" placeholder="Username" id="new-cusername" required/>
					</div>
					<div class="form-group">
						<label for="Email">Email</label>
						<input type="email" class="form-control" name="new_cuser_email" placeholder="Email address" id="new-cuseremail" required/>
					</div>
					<div class="form-group">
						<label for="Password">Password</label>
						<input type="password" class="form-control" name="new_cuser_password" placeholder="Password" id="new-cuserpassword" required/>
					</div>
					<div class="form-group">
						<label for="RePassword">Re Enter Password</label>
						<input type="password" class="form-control" name="cre-pwd" placeholder="Re-enter Password" id="cre-pwd" required/>
					</div>
					<div class="form-group">
						<input type="submit" class="button" id="register-cbutton" value="Register" >
					</div>
					<div id="result_msg_cclient">
							
					</div>
		      </fieldset>
		    </form>
		</div>
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
    	//for contractor
     jQuery('#register-cbutton').on('click',function(e){
        e.preventDefault();
        var newcUserName = jQuery('#new-cusername').val();
        var newcUserEmail = jQuery('#new-cuseremail').val();
        var newcUserPassword = jQuery('#new-cuserpassword').val();
        var new_bname = jQuery('#new_bname').val();
        var bnumber = jQuery('#bnumber').val();
        var recUserPassword = jQuery('#cre-pwd').val();
        var cemailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var cvalid_email = '';
        var chasError = false;
        if(newcUserEmail == '') {
	      	jQuery('#result_msg_cclient').text('Please enter your email address.').show();
	      	chasError = true;
	    }
	    else if(!cemailReg.test(newcUserEmail)) {
	      	jQuery('#result_msg_cclient').text('Enter a valid email address.').show();
	      	chasError = true;
	    }
	    else{
	    	cvalid_email = newcUserEmail;
	    }
		if((newcUserName.length>0)&&(cvalid_email.length>0)&&(newcUserPassword.length>0)&&(recUserPassword.length>0)){
        	if(newcUserPassword==recUserPassword){
	        	jQuery.ajax({
	                type:"POST",
	                url:"<?php echo admin_url('admin-ajax.php'); ?>",
	                data: {
	                    action: "register_client_user_front_end",
	                    new_cuser_name : newcUserName,
	                    new_cuser_email : cvalid_email,
	                    new_bname : new_bname,
	                    bnumber : bnumber,
	                    new_cuser_password : newcUserPassword
	                },
	                success: function(result){
	                  	if(result.success==true){
							jQuery('#resgistration_form')[0].reset();
						}
						jQuery('#result_msg_cclient').text(result).show();
	                },
	                error: function(result) {
	        			
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



     // for client
    jQuery('#register-button').on('click',function(e){
        e.preventDefault();
        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        var reUserPassword = jQuery('#re-pwd').val();
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
	                    new_user_password : newUserPassword
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