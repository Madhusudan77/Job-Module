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
        var number = Math.floor(1000 + Math.random() * 9000);
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        var valid_email = '';
        var hasError = false;
        if(newUserName == ''){
        	jQuery('.username_error').text('Please enter name.').show();
        }else{
        	jQuery('.username_error').text('Please enter name.').hide();
        }
        if(newUserPassword == ''){
        	jQuery('.password_error').text('Please enter password.').show();
        }else{
        	jQuery('.password_error').text('Please enter password').hide();
        }
        if(new_bname == ''){
        	jQuery('.businessname_error').text('Please enter password.').show();
        }else{
        	jQuery('.businessname_error').text('Please enter password').hide();
        }
        if(bnumber == ''){
        	jQuery('.businessno_error').text('Please enter password.').show();
        }else{
        	jQuery('.businessno_error').text('Please enter password').hide();
        }

        if(newUserEmail == '') {
	      	jQuery('.email_error').text('Please enter your email address.').show();
	      	hasError = true;
	    }
	    else if(!emailReg.test(newUserEmail)) {
	      	jQuery('.email_error').text('Enter a valid email address.').show();
	      	hasError = true;
	    }
	    else{
	    	valid_email = newUserEmail;
	    	jQuery('.email_error').text('Enter a valid email address.').hide();
	    }

	    if (jQuery("body").hasClass("page-id-155")) {
	    	var business_code = 'business_code';
	    }else{
	    	var business_code = 'contrator';
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
	                    bnumber : bnumber,
	                    number : number
	                },
	                success: function(results){
	                  	
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
	        jQuery('#result_msg_client').text("All fields are required").show();
	    }
    });
  	
</script>
<?php wp_footer(); ?>

</body>
</html>
