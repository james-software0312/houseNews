/**
 * Account Settings - Security
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Enable OTP form validation
    FormValidation.formValidation(document.getElementById('enableOTPForm'), {
      fields: {
        email: {
          validators: {
            notEmpty: {
              message: 'Please enter your email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        },
        verification_code: {
          validators: {
            // notEmpty: {
            //   message: 'Please enter the verification code'
            // },
            stringLength: {
              min: 6,
              max: 6,
              message: 'The code must be 6 characters long'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    }).on('core.form.valid', function (e) {
      console.log('Form is valid!');
      // Form is valid, handle submission
      const email = $('#email').val();
      const code = $('#verification_code').val();
      const isCodeStage = !$('#code-input').hasClass('d-none');

      $('#alert').hide();
      if (!isCodeStage) {
        $('#email-input').addClass('d-none');
        $('#code-input').removeClass('d-none');
        $('#instruction').text('Enter the verification code sent to your email.');
        $('#submit-btn').text('Verify Code');

        $.ajax({
          url: '/setting/send-otp', // Replace with your API endpoint
          type: 'POST',
          data: { email },
          success: function (response) {
            $('#alert').show();
            if (response.success) {
              $('#alert').css('color', 'green');
            } else {
              $('#alert').css('color', 'red');

              $('#email-input').removeClass('d-none');
              $('#code-input').addClass('d-none');
              $('#instruction').text('Enter your email and we will send you a verification code.');
              $('#submit-btn').text('Submit');
            }
            $('#alert').html(response.message);
          },
          error: function () {
            $('#alert').show();
            $('#alert').css('color', 'red');
            $('#alert').html('Failed to send OTP. Please try again.');

            $('#email-input').removeClass('d-none');
            $('#code-input').addClass('d-none');
            $('#instruction').text('Enter your email and we will send you a verification code.');
            $('#submit-btn').text('Submit');
          }
        });
      } else {
        // Step 2: Verify OTP
        $.ajax({
          url: '/setting/verify-otp', // Replace with your API endpoint
          type: 'POST',
          data: { email, code },
          success: function (response) {
            $('#defaultInput').val(email);
            $('#enableOTPForm')[0].reset();
            $('#email-input').removeClass('d-none');
            $('#code-input').addClass('d-none');
            $('#enableOTP').modal('hide');
          },
          error: function () {
            $('#alert').show();
            $('#alert').css('color', 'red');
            $('#alert').html('Invalid verification code. Please try again.');
          }
        });
      }
    });
    $('#enableOTP').on('show.bs.modal', function () {
      // Reset the form
      $('#enableOTPForm')[0].reset();

      // Reset visibility for the input sections
      $('#email-input').removeClass('d-none');
      $('#code-input').addClass('d-none');

      // Reset instructions and button text
      $('#instruction').text('Enter your email and we will send you a verification code.');
      $('#submit-btn').text('Submit');
      $('#alert').hide();
    });

    const formChangePass = document.querySelector('#formAccountSettings');

    // Form validation for Change password
    if (formChangePass) {
      const fv = FormValidation.formValidation(formChangePass, {
        fields: {
          currentPassword: {
            validators: {
              notEmpty: {
                message: 'Please current password'
              },
              stringLength: {
                min: 6,
                message: 'Password must be more than 6 characters'
              }
            }
          },
          newPassword: {
            validators: {
              notEmpty: {
                message: 'Please enter new password'
              },
              stringLength: {
                min: 8,
                message: 'Password must be more than 8 characters'
              },
              regexp: {
                regexp: /^(?=.*[A-Z])(?=.*[0-9!@#$%^&*]).*$/,
                message: 'Password must contain at least one uppercase letter and one number or symbol'
              }
            }
          },
          confirmPassword: {
            validators: {
              notEmpty: {
                message: 'Please confirm new password'
              },
              identical: {
                compare: function () {
                  return formChangePass.querySelector('[name="newPassword"]').value;
                },
                message: 'The password and its confirm are not the same'
              },
              stringLength: {
                min: 8,
                message: 'Password must be more than 8 characters'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.col-md-6'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }
  })();
});

// Select2 (jquery)
$(function () {
  var select2 = $('.select2');

  // Select2 API Key
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        dropdownParent: $this.parent()
      });
    });
  }
});
