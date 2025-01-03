/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    const flatpickrRange = document.querySelector('.flatpickr');

    if (flatpickrRange) {
      flatpickrRange.flatpickr({
        dateFormat: 'd M, Y',
        disableMobile: true,
        defaultDate: flatpickrRange.value
      });
    }
    const formAccSettings = document.querySelector('#formAccountSettings');
    // Form validation for Add new record
    if (formAccSettings) {
      const fv = FormValidation.formValidation(formAccSettings, {
        fields: {
          first_name: {
            validators: {
              notEmpty: {
                message: 'Please enter first name'
              }
            }
          },
          last_name: {
            validators: {
              notEmpty: {
                message: 'Please enter last name'
              }
            }
          },
          pec_email: {
            validators: {
              notEmpty: {
                message: 'Please enter pec email'
              },
              emailAddress: {
                message: 'The value is not a valid email address'
              }
            }
          },
          birthday: {
            validators: {
              notEmpty: {
                message: 'Please enter date of birth'
              }
            }
          },
          birth_country: {
            validators: {
              notEmpty: {
                message: 'Please enter country of birth'
              }
            }
          },
          birth_city: {
            validators: {
              notEmpty: {
                message: 'Please enter city of birth'
              }
            }
          },
          address: {
            validators: {
              notEmpty: {
                message: 'Please enter address'
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

    // Update/reset user image of account page
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});

// Select2 (jquery)
$(function () {
  var select2 = $('.select2');
  // For all Select2
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

let homeaddressField, birthCityField, birthCountryField;
let autocomplete, autocompleteBithCity, autocompleteBithCountry;

function initAutocomplete() {
  homeaddressField = document.querySelector('#home_address');
  birthCityField = document.querySelector('#birth_city');
  birthCountryField = document.querySelector('#birth_country');

  autocomplete = new google.maps.places.Autocomplete(homeaddressField, {
    componentRestrictions: { country: ['it'] },
    fields: ['address_components', 'geometry'],
    types: ['address']
  });
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
