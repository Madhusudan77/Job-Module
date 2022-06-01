<?php
/* 
Template Name: Registration form
*/
get_header();
?>
<div class="outer_class">
	<div class="container">
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

<script type="text/javascript">

	jQuery(document).ready(function(){
		jQuery('#frmContactUs').submit(function(){
			event.preventDefault();
			jQuery('#result_msg').html('');
			var link = "<?php echo admin_url('admin-ajax.php') ?>";
			var form = jQuery('#frmContactUs').serialize();
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
						jQuery('#frmContactUs')[0].reset();
					}
					jQuery('#result_msg').html('<h3><span class="'+result.success+'">'+result.data+'</span></h3>')
				}
			});
		});
	});
</script>

<?php get_footer();