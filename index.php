<?php get_header(); ?>


<?php $postTitle = $_POST['post_title'];
$post = $_POST['post'];
$submit = $_POST['submit'];

if(isset($submit)){

    global $user_ID;

    $new_post = array(
        'post_title' => $postTitle,
        'post_content' => $post,
        'post_status' => 'publish',
        'post_date' => date('Y-m-d H:i:s'),
        'post_author' => $user_ID,
        'post_type' => 'post',
        'post_category' => array(0)
    );

    wp_insert_post($new_post);

}

?>

<div id="wrap">
<form action="" method="post">
<table border="1" width="200">
  <tr>
    <td><label for="post_title">Post Title</label></td>
    <td><input name="post_title" type="text" /></td>
  </tr>
  <tr>
    <td><label for="post">Post</label></td>
    <td><input name="post" type="text" /></td>
  </tr>
</table>

<input name="submit" type="submit" value="submit" />
</form>
</div>




<div class="container">
	<div class="service_class">
		<div class="header_class">
			<h2>Register Yourself Here:  </h2>
		</div>
		<ul class="nav nav-tabs navigation_tabs">
		    <li class="active"><a data-toggle="tab" href="#home">Client</a></li>
		    <li><a data-toggle="tab" href="#menu1">Contractor</a></li>
		</ul>

		<div class="tab-content">
		    <div id="home" class="tab-pane fade in active">
		    	<h3>Client</h3>
		      	<form id="clientform">
					<div class="form-group">
					    <label for="Name">First Name</label>
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
		    <div id="menu1" class="tab-pane fade">
		      	<h3>Contractor</h3>
		      	<form id="frmContactUs">
					<div class="form-group">
					    <label for="Name">First Name</label>
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
					    <label for="BName">Business Name</label>
					    <input type="text" class="form-control" name="bname" id="bname" placeholder="Business Name" required/>
					</div>
					<div class="form-group">
					    <label for="BNumber">Business Number</label>
					    <input type="tel" class="form-control" name="bnumber" id="bnumber" placeholder="Business Number" required/>
					</div>
					<div class="form-group">
					    <input type="submit" class="form-control" name="submit" id="submit" placeholder="Submit" >
					</div>
					<div id="result_msg">
						
					</div>
				</form>
		    </div>
		</div>
	</div>
</div>

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

	jQuery(document).ready(function(){
		jQuery('#frmContactUs').submit(function(){
			event.preventDefault();
			jQuery('#result_msg').html('');
			var link = "<?php echo admin_url('admin-ajax.php') ?>";
			var form = jQuery('#frmContactUs').serialize();
			var formData = new FormData;
			formData.append('action', 'contact_us_contractor');
			formData.append('contact_us_contractor', form);
			jQuery.ajax({
				url:link,
				data:formData,
				processData:false,
				contentType:false,
				type:'post',
				success:function(result){
					if(result.success==true){
						jQuery('#frmContactUs')[0].reset();
					}
					jQuery('#result_msg').html('<h3><span class="'+result.success+'">'+result.data+'</span></h3>')
				}
			});
		});
	});
</script>

<?php get_footer(); ?>