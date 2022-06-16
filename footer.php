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
	                  	jQuery('#resgistration_form')[0].reset();
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
  	




    //job form query
    jQuery('#form_submit_btn').on('click',function(e){
        e.preventDefault();
        var jobtitle = jQuery('#jobtitle').val();
        var jobDesc = jQuery('#jobDesc').val();
        var jobAmt = jQuery('#jobAmt').val();
        var payAmt = jQuery('#payAmt').val();
        var fileInputElement = document.getElementById("file");
  		var fileName = fileInputElement.files[0].name;
        var note_client = jQuery('#note_client').val();
        var perNotes = jQuery('#perNotes').val();
        if(jobAmt == ''){
        	jQuery('.jobAmt_error').text('Please enter amount.').show();
        }else{
        	jQuery('.jobAmt_error').text('Please enter amount.').hide();
        }
        if(payAmt == ''){
        	jQuery('.payAmt_error').text('Please enter amount.').show();
        }else{
        	jQuery('.payAmt_error').text('Please enter amount.').hide();
        }
        if(jobtitle == ''){
        	jQuery('.title_error').text('Please enter job title.').show();
        }else{
        	jQuery('.title_error').text('Please enter job title.').hide();
        }
        if((jobtitle.length>0)&&(jobAmt.length>0)&&(payAmt.length>0)){
        	jQuery.ajax({
                type:"POST",
                url:"<?php echo admin_url('admin-ajax.php'); ?>",
                data: {
                    action: "create_form_post",
                    jobtitle : jobtitle,
                    jobDesc : jobDesc,
                    jobAmt : jobAmt,
                    payAmt : payAmt,
                    fileName : fileName,
                    note_client : note_client,
                    perNotes : perNotes
                },
                success: function(data){
                	jQuery('#post_form')[0].reset();
					jQuery('#message_show').text(data).show();
                },
                error: function(data) {
        			
                }
            });
            jQuery('#message_show').removeClass('field_errors')
        }else{
        	jQuery('#message_show').addClass('field_errors')
        	jQuery('#message_show').text('Fields are required.').show();
        }	
    });


    //scolling ajax
  	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
	var page_count = '<?php echo ceil(wp_count_posts('jobs')->publish/2);?>';
    var page = 1;
    
    if (jQuery("#job_posts").hasClass("contractor_class")) {
    	var jobs_class = 'contractor';
    }
    else{
    	var jobs_class = 'client';
    }
    jQuery(document).ready(function(){
    	jQuery('#loading').html('<p><img src="http://localhost/services/wp-content/uploads/2022/06/ajax-loader.gif"></p>');
        var data = {
            'action':'load_more_action',
            'page':page,
            'jobs_class':jobs_class
        };
        jQuery.ajax({
        	type:'POST',
        	url:ajaxurl,
            data:data,
            success: function(response){
            	jQuery('#job_posts').append(response);
	            page=page+1;
				if(page_count==page){
					jQuery('#loading').empty();
	            	jQuery('#job_posts').append('<div class="no_more_class">No More jobs</div>');
	            }
				var canBeLoaded = true; // this parameter allows to initiate the AJAX call only if necessary
				var   bottomOffset = jQuery(window).height()+20;
			 
				jQuery(window).scroll(function(){
					var data = {
						'action': 'load_more_action',
						'page' : page
					};
					if( jQuery(document).scrollTop() > ( jQuery(document).height() - bottomOffset ) && canBeLoaded == true ){
						jQuery('#loading').html('<p><img src="http://localhost/services/wp-content/uploads/2022/06/ajax-loader.gif"></p>');
						jQuery.ajax({
							url : ajaxurl,
							data:data,
							type:'POST',
							beforeSend: function( xhr ){
								canBeLoaded = false; 
							},
							success:function(response){
								if( response ) {
									jQuery('#job_posts').append(response);
									canBeLoaded = true;
									page++;
								}
								if(page_count==page){
					            	jQuery('#job_posts').append('<div class="no_more_class">No More jobs</div>');
					            }
							}
						});
					}
					else{
						jQuery('#loading').empty();
					}
				});
            },
            error: function(response) {
    			
            }
            
        });
    });
</script>
<?php wp_footer(); ?>

</body>
</html>
