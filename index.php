<?php
acf_form_head();
 get_header(); ?>

<div class="container">

<?php if (is_user_logged_in()) {?>
	<form  action="#" id="post_form" method="POST" name="form_post" class="register-form" enctype="multipart/form-data">
		<div id="message_show">
                            
    	</div>
		<div class="form-group">
		    <label for="jobTitle">Job Title</label>
		    <input type="text" class="form-control" id="jobtitle" required/>
		    <div class="title_error field_error"></div>
  		</div>
  		<div class="form-group">
    		<label for="jobDesc">Job Description</label>
    		<textarea class="form-control" id="jobDesc" rows="3"></textarea>
  		</div>
  		<div class="row">
    		<div class="col">
    			<label for="jobAmt">Total Job Amount</label>
      			<input type="text" class="form-control"  id="jobAmt" required/>
      			<div class="jobAmt_error field_error"></div>
    		</div>
    		<div class="col">
    			<label for="payAmt">Payment Amount</label>
      			<input type="text" class="form-control"  id="payAmt" required/>
      			<div class="payAmt_error field_error"></div>
    		</div>
  		</div>
  		<div class="form-group">
    			<label for="upPhotos">Upload Plotos</label>
    			<input type="file" name="file" id="file" />
  			</div>
  			<hr>
  			<div class="form-group">
	    		<label for="note_client">Notes for Client</label>
	    		<textarea class="form-control" id="note_client" rows="3"></textarea>
	  		</div>
	  		<div class="form-group">
	    		<label for="perNotes">Personal Notes</label>
	    		<textarea class="form-control" id="perNotes" rows="3"></textarea>
	  		</div>
	  		<input class="btn btn-primary" id="form_submit_btn" type="submit" value="Create Job">
	  	</form>
	</form>
	
</div>
	
<?php }?>

</div>
<script type="text/javascript">
	
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

</script>
<?php get_footer(); ?>