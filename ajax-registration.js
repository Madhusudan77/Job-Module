jQuery(document).ready(function($) {
 
  $('#btn-new-user').click( function(event) {
    if (event.preventDefault) {
        event.preventDefault();
    } else {
        event.returnValue = false;
    }
 
    $('.indicator').show();
    $('.result-message').hide();
 
    // Collect data from inputs
    var reg_nonce = $('#vb_new_user_nonce').val();
    var reg_user  = $('#vb_username').val();
    var reg_pass  = $('#vb_pass').val();
    var reg_mail  = $('#vb_email').val();
    var reg_name  = $('#vb_name').val();
    var reg_nick  = $('#vb_nick').val();
    var ajax_url = vb_reg_vars.vb_ajax_url;
 
    // Data to send
    data = {
      action: 'register_user',
      nonce: reg_nonce,
      user: reg_user,
      pass: reg_pass,
      mail: reg_mail,
      name: reg_name,
      nick: reg_nick,
    };
    $.post( ajax_url, data, function(response) {
 
      if( response ) {
 
        $('.indicator').hide();
 
        if( response === '1' ) {
          $('.result-message').html('Your submission is complete.'); 
          $('.result-message').addClass('alert-success'); 
          $('.result-message').show(); 
        } else {
          $('.result-message').html( response ); 
          $('.result-message').addClass('alert-danger');
          $('.result-message').show(); 
        }
      }
    });
 
  });
});