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

<?php get_footer(); ?>