/**
 * File Upload
 */

'use strict';

(function () {
  //------------------------------------------------------------------------------------------
  const flatpickrRange = document.querySelector('.flatpickr');

  if (flatpickrRange) {
    flatpickrRange.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrRange.value
    });
  }
  const flatpickrID = document.querySelector('#id_date');

  if (flatpickrID) {
    flatpickrID.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrRange.value
    });
  }

  // previewTemplate: Updated Dropzone default previewTemplate
  // ! Don't change it unless you really know what you are doing
  const previewTemplate = `<div class="dz-preview dz-file-preview">
    <div class="dz-details">
    <div class="dz-thumbnail">
        <img data-dz-thumbnail>
        <span class="dz-nopreview">No preview</span>
        <div class="dz-success-mark"></div>
        <div class="dz-error-mark"></div>
        <div class="dz-error-message"><span data-dz-errormessage></span></div>
        <div class="progress">
        <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
        </div>
    </div>
    <div class="dz-filename" data-dz-name></div>
    <div class="dz-size" data-dz-size></div>
    </div>
    </div>`;

  // --------------------------------------------------------------------
  const passportUpload = document.querySelector('#passport-area');
  if (passportUpload) {
    const myPassportDropzone = new Dropzone(passportUpload, {
      previewTemplate: previewTemplate,
      parallelUploads: 1,
      maxFilesize: 5,
      addRemoveLinks: true,
      maxFiles: 1,
      acceptedFiles: 'image/*',

      init: function () {
        const existingFileUrl = $('#id_card_path').val();
        console.log(existingFileUrl);

        if (existingFileUrl) {
          // Create a mock file object
          const mockFile = {
            name: 'passport', // File name
            size: 12345, // Approximate file size (in bytes)
            type: 'image/jpeg' // Set the file type
          };

          // Add the file to the Dropzone instance
          this.displayExistingFile(mockFile, existingFileUrl);

          // Optionally mark the file as successfully uploaded
          this.emit('complete', mockFile);
        }
      },
      success: function (file, response) {
        const imageFile = file;

        // You can access the file content as a data URL, which is especially useful for image previews:
        if (imageFile.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function (e) {
            const imageUrl = e.target.result;
            $('#id_card').val(imageUrl);

            // const imgElement = document.createElement('img');
            // imgElement.src = imageUrl;
            // document.body.appendChild(imgElement);
          };
          reader.readAsDataURL(imageFile);
        }
      }
    });
  }

  const taskForm = document.querySelector('#task-details-panel');
  const FormValidation1 = FormValidation.formValidation(taskForm, {
    fields: {
      // * Validate the fields here based on your requirements

      first_name: {
        validators: {
          notEmpty: {
            message: 'Please enter your first name'
          }
        }
      },
      last_name: {
        validators: {
          notEmpty: {
            message: 'Please enter your last name'
          }
        }
      },
      birthday: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      birth_city: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      birth_country: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      nationality: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      address: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      id_type: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      id_num: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      id_date: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      id_authority: {
        validators: {
          notEmpty: {
            message: 'This field is required'
          }
        }
      },
      terms_conditions: {
        validators: {
          notEmpty: {
            message: 'You must agree before submitting'
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
        // rowSelector: '.col-sm-9'
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          switch (field) {
            case 'terms_conditions':
              return '.form-check';
            default:
              return '.col-sm-9';
          }
        }
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton()
    },
    init: instance => {
      instance.on('plugins.message.placed', function (e) {
        //* Move the error message out of the `input-group` element
        if (e.element.parentElement.classList.contains('input-group')) {
          e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
        }
      });
    }
  }).on('core.form.valid', function () {
    // Jump to the next step when all fields in the current step are valid
    submit_doc();
  });

  const privacyPolicyForm = document.querySelector('#privacy-policy');
  const FormValidation2 = FormValidation.formValidation(privacyPolicyForm, {
    fields: {
      terms_conditions: {
        validators: {
          notEmpty: {
            message: 'You must agree before submitting'
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
        // rowSelector: '.col-sm-9'
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          switch (field) {
            case 'terms_conditions':
              return '.form-check';
            default:
              return '.col-sm-9';
          }
        }
      }),
      autoFocus: new FormValidation.plugins.AutoFocus(),
      submitButton: new FormValidation.plugins.SubmitButton()
    },
    init: instance => {
      instance.on('plugins.message.placed', function (e) {
        //* Move the error message out of the `input-group` element
        if (e.element.parentElement.classList.contains('input-group')) {
          e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
        }
      });
    }
  }).on('core.form.valid', function () {
    // Jump to the next step when all fields in the current step are valid
    FormValidation1.validate();
  });
  let check_num = 0;
  $(document).on('click', '.send-email', function () {
    check_num = 0;
    FormValidation2.validate();
  });

  function submit_doc() {
    var url = $('.send-email').data('url'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // sweetalert for confirmation of delete
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, send it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        Swal.fire({
          title: 'Sending...',
          text: 'Please wait while we send the email.',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false, // Hide the confirm button
          showCancelButton: false, // Hide the cancel button
          didOpen: () => {
            Swal.showLoading(); // Show the loading spinner
          }
        });

        $.ajax({
          data: $('#task-details-panel').serialize(),
          type: 'POST',
          url: url,
          success: function (response) {
            $('.badge').attr('class', 'badge px-2 bg-label-warning text-capitalized');
            $('.badge').html('Waiting');

            if (response && response.success) {
              Swal.fire({
                icon: 'success',
                title: 'Submit!',
                text: 'Your document was submitted!',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then(() => {
                // location.reload();
              });
            } else {
              Swal.fire({
                title: 'Failed',
                text: 'The document is not submit!',
                icon: 'error',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              });
            }
          },
          error: function (error) {
            console.log(error);
            Swal.fire({
              title: 'Failed',
              text: 'The document is not submit!',
              icon: 'error',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            });
          }
        });
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelled',
          text: 'The document is not submit!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  }
  $('#id_type').change(function () {
    // Get the selected value
    var selectedValue = $(this).val();
    if (selectedValue == 'passport') {
      $('#id_type_label').html('Passport');
    } else if (selectedValue == 'idcard') {
      $('#id_type_label').html('ID Card');
    }
  });
})();

let homeaddressField, birthCityField, birthCountryField;
let autocomplete, autocompleteBithCity, autocompleteBithCountry;

function initAutocomplete() {
  homeaddressField = document.querySelector('#address');
  birthCityField = document.querySelector('#birth_city');
  birthCountryField = document.querySelector('#birth_country');

  autocomplete = new google.maps.places.Autocomplete(homeaddressField, {
    // componentRestrictions: { country: ["it"] },
    fields: ['address_components', 'geometry'],
    types: ['address']
  });
  //   autocomplete.addListener("place_changed", fillInAddress);
  autocompleteBithCity = new google.maps.places.Autocomplete(birthCityField, {
    fields: ['address_components', 'geometry', 'formatted_address'],
    types: ['(cities)']
  });
  autocompleteBithCity.addListener('place_changed', fillInBithCity);
  autocompleteBithCountry = new google.maps.places.Autocomplete(birthCountryField, {
    types: ['(regions)']
  });
}

function fillInBithCity() {
  // Get the place details from the autocomplete object.
  const place = autocompleteBithCity.getPlace();
  for (const component of place.address_components) {
    if (component.types.includes('country')) {
      document.querySelector('#birth_country').value = component.long_name;
    }
    if (component.types.includes('locality')) {
      document.querySelector('#birth_city').value = component.long_name;
    }
  }
}

window.onload = initAutocomplete;
