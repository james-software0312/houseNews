/**
 * UI Toasts
 */

'use strict';

//Toastr (jquery)
// --------------------------------------------------------------------
$(function () {
  var i = -1;
  var toastCount = 0;
  var $toastlast;
  $('#resend').on('click', function () {    
    let email = $('#email').val();
    $.ajax({
        type: 'POST',
        // url: '{{ route("verify.resent") }}',
        url: `${baseUrl}verify-resent`,
        data: {email : email},
        success: function (reseponse) {
            if(reseponse.success)
                toastr['success']("Email was sent successfuly!", "Verify Your Email"); 
            else
                toastr['error']("Email was not sent!", "Verify Your Email"); 
        },
        error: function (error) {
          console.log(error);
          toastr['error']("Email was not sent!", "Verify Your Email"); 
        }
      });


  });

});
