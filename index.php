<?php get_header(); ?>


<?php if (is_user_logged_in()) { ?>
    <a class="login_button" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
<?php } else { ?>
    <a class="login_button" id="show_login" href="">Login</a>
<?php } 

if (!is_user_logged_in()) {?>
	<ul class="nav nav-tabs navigation_tabs">
		<li class="active"><a data-toggle="tab" href="#home">Contractor</a></li>
		<li><a data-toggle="tab" href="#menu1">Client</a></li>
	</ul>
	<div class="tab-content">
		<div id="home" class="tab-pane fade in active">
  			<?php echo do_shortcode('[vb_registration_form]'); ?>  
    	</div>
    	<div id="menu1" class="tab-pane fade">
    		<h3>Client</h3>
	      	<form id="clientform">
				<div class="form-group">
				    <label for="Name">Name</label>
				    <input type="text" class="form-control" name="name" id="name" placeholder="Name" required/>
				</div>
				<div class="form-group">
				    <label for="Email">Email</label>
				    <input type="email" class="form-control" name="email" id="email" placeholder="Email" required/>
				</div>
				<div class="form-group">
				    <label for="Phone">Phone No.</label>
				    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone" required/>
				</div>
				<div class="form-group">
				    <label for="Address">Address</label>
				    <input type="text" class="form-control" name="address" id="address" placeholder="Address" required/>
				</div>
				<div class="form-group">
				    <input type="submit" class="form-control" name="submit" id="submit" placeholder="Submit" >
				</div>
				<div id="result_msg_client">
					
				</div>
			</form>
    	</div>
    </div>
<?php }?>
	
     

    
    <!-- login form -->
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


<!-- ajax for form registration -->
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#clientform').submit(function(){
			event.preventDefault();
			jQuery('#result_msg_client').html('');
			var link = "<?php echo admin_url('admin-ajax.php') ?>";
			var form = jQuery('#clientform').serialize();
			var formData = new FormData;
			formData.append('action', 'contact_us');
			formData.append('contact_us', form);
			jQuery.ajax({
				url:link,
				data:formData,
				processData:false,
				contentType:false,
				type:'post',
				success:function(result){
					if(result.success==true){
						jQuery('#clientform')[0].reset();
					}
					jQuery('#result_msg_client').html('<h3><span class="'+result.success+'">'+result.data+'</span></h3>')
				}
			});
		});
	});

    jQuery('#register-button').on('click',function(e){
        e.preventDefault();
        var newUserName = jQuery('#new-username').val();
        var newUserEmail = jQuery('#new-useremail').val();
        var newUserPassword = jQuery('#new-userpassword').val();
        jQuery.ajax({
          type:"POST",
          url:"<?php echo admin_url('admin-ajax.php'); ?>",
          data: {
            action: "register_user_front_end",
            new_user_name : newUserName,
            new_user_email : newUserEmail,
            new_user_password : newUserPassword
          },
          success: function(results){
            console.log(results);
            jQuery('.register-message').text(results).show();
          },
          error: function(results) {

          }
        });
      });
</script>
<?php get_footer(); ?>