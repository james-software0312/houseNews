/**
 *  Form Wizard
 */

'use strict';

(function () {
  // Init custom option check
  window.Helpers.initCustomOptionCheck();

  const flatpickrRange = document.querySelector('.flatpickr'),
    phoneMask = document.querySelector('.contact-number-mask'),
    plCountry = $('#plCountry'),
    plFurnishingDetailsSuggestionEl = document.querySelector('#plFurnishingDetails');

  // Phone Number Input Mask
  if (phoneMask) {
    new Cleave(phoneMask, {
      phone: true,
      phoneRegionCode: 'US'
    });
  }

  // select2 (Country)

  if (plCountry) {
    plCountry.wrap('<div class="position-relative"></div>');
    plCountry.select2({
      placeholder: 'Select country',
      dropdownParent: plCountry.parent()
    });
  }

  if (flatpickrRange) {
    flatpickrRange.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrRange.value
    });
  }

  const flatpickrStart = document.querySelector('#start_date');
  const flatpickrEnd = document.querySelector('#end_date');

  let startDatePicker, endDatePicker;

  if (flatpickrStart) {
    startDatePicker = flatpickrStart.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrStart.value || new Date(),
      minDate: new Date(),
      onChange: function (selectedDates) {
        if (endDatePicker) {
          endDatePicker.set('minDate', selectedDates[0]); // Set the minimum date for end date
        }
      }
    });
  }

  if (flatpickrEnd) {
    endDatePicker = flatpickrEnd.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrEnd.value,
      minDate: flatpickrStart ? flatpickrStart.value : new Date() // Link with start date
    });
  }
  // Vertical Wizard
  // --------------------------------------------------------------------

  const wizardPropertyListing = document.querySelector('#wizard-property-listing');
  if (typeof wizardPropertyListing !== undefined && wizardPropertyListing !== null) {
    // Wizard form
    const wizardPropertyListingForm = wizardPropertyListing.querySelector('#wizard-property-listing-form');
    // Wizard steps
    const wizardPropertyListingFormStep1 = wizardPropertyListingForm.querySelector('#task-name');
    const wizardPropertyListingFormStep2 = wizardPropertyListingForm.querySelector('#declarant-info');
    const wizardPropertyListingFormStep3 = wizardPropertyListingForm.querySelector('#start-end-dates');
    const wizardPropertyListingFormStep4 = wizardPropertyListingForm.querySelector('#rental-property-address');
    const wizardPropertyListingFormStep5 = wizardPropertyListingForm.querySelector('#guest-info');
    // Wizard next prev button
    const wizardPropertyListingNext = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-next'));
    const wizardPropertyListingPrev = [].slice.call(wizardPropertyListingForm.querySelectorAll('.btn-prev'));

    const validationStepper = new Stepper(wizardPropertyListing, {
      linear: true
    });

    // Personal Details
    const FormValidation1 = FormValidation.formValidation(wizardPropertyListingFormStep1, {
      fields: {
        // * Validate the fields here based on your requirements
        task_name: {
          validators: {
            notEmpty: {
              message: 'Please enter the task name'
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
          rowSelector: '.col-sm-12'
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
      // validationStepper.next();

      $.ajax({
        type: 'POST',
        url: $('#wizard-property-listing-form').attr('action'),
        data: { task_name: $('#task_name').val() },
        success: function (response) {
          if (response.success) {
            window.location.href = response.url;
          } else {
            toastr['error'](`We found error in your process`, 'Task');
          }
        },
        error: function () {
          toastr['error'](`We found error in your process`, 'Task');
        }
      });
    });

    // Property Details
    const FormValidation2 = FormValidation.formValidation(wizardPropertyListingFormStep2, {
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
        address: {
          validators: {
            notEmpty: {
              message: 'This field is required'
            }
          }
        },
        pec_email: {
          validators: {
            notEmpty: {
              message: 'Please enter your pec email'
            },
            emailAddress: {
              message: 'The value is not a valid email address'
            }
          }
        }
        // plZipCode: {
        //   validators: {
        //     notEmpty: {
        //       message: 'Please enter zip code'
        //     },
        //     stringLength: {
        //       min: 4,
        //       max: 10,
        //       message: 'The zip code must be more than 4 and less than 10 characters long'
        //     }
        //   }
        // }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            switch (field) {
              case 'plAddress':
                return '.col-lg-12';
              default:
                return '.col-sm-6';
            }
          }
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // Jump to the next step when all fields in the current step are valid
      validationStepper.next();
    });

    function toggleRentalPropertyPanel() {
      const selectedProperty = $('#property_id').val();

      // Show panel if either condition is met
      if (selectedProperty) {
        $('#rental_property_panel').removeClass('d-none');
        $('#rental_property_next_btn').removeClass('disabled');

        if (selectedProperty) {
          // Get the data attributes of the selected property
          const selectedOption = $('#property_id option:selected');
          $('#rental_commune').val(selectedOption.data('rental_commune'));
          $('#rental_address').val(selectedOption.data('rental_address'));
          $('#street_num').val(selectedOption.data('street_num'));
          $('#int_num').val(selectedOption.data('int_num'));
          $('#floor').val(selectedOption.data('floor'));
        } else {
          // Clear the fields if "Create a New Property" is checked
          $('#rental_commune').val('');
          $('#rental_address').val('');
          $('#street_num').val('');
          $('#int_num').val('');
          $('#floor').val('');
        }
      } else {
        $('#rental_property_panel').addClass('d-none');
      }
    }
    $('#declarant_id').on('change', function () {
      $('#first_name').val('');
      $('#last_name').val('');
      $('#birthday').val('');
      $('#birth_city').val('');
      $('#birth_country').val('');
      $('#home_address').val('');
      $('#pec_email').val('');
      $('#uploadedAvatar').attr('src', '/assets/img/avatar.png');

      if ($(this).val() === '0') {
      } else {
        const selectedOption = $('#declarant_id option:selected');
        $('#first_name').val(selectedOption.data('first_name'));
        $('#last_name').val(selectedOption.data('last_name'));
        $('#birthday').val(selectedOption.data('birthday'));
        $('#birth_city').val(selectedOption.data('birth_city'));
        $('#birth_country').val(selectedOption.data('birth_country'));
        $('#home_address').val(selectedOption.data('address'));
        $('#pec_email').val(selectedOption.data('pec_email'));
        $('#uploadedAvatar').attr('src', selectedOption.data('avatar'));
      }
    });
    // select2 (Property type)
    // const plPropertyType = $('#plPropertyType');
    // if (plPropertyType.length) {
    //   plPropertyType.wrap('<div class="position-relative"></div>');
    //   plPropertyType
    //     .select2({
    //       placeholder: 'Select property type',
    //       dropdownParent: plPropertyType.parent()
    //     })
    //     .on('change', function () {
    //       // Revalidate the color field when an option is chosen
    //       FormValidation2.revalidateField('plPropertyType');
    //     });
    // }

    // Start Date / Finish Date
    const FormValidation3 = FormValidation.formValidation(wizardPropertyListingFormStep3, {
      fields: {
        start_end_date: {
          validators: {
            notEmpty: {
              message: 'This field is required'
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
          rowSelector: '.col-md-6'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      validationStepper.next();
    });

    // Property Area
    const FormValidation4 = FormValidation.formValidation(wizardPropertyListingFormStep4, {
      fields: {
        // * Validate the fields here based on your requirements
        rental_commune: {
          validators: {
            notEmpty: {
              message: 'This field is required'
            }
          }
        },
        rental_address: {
          validators: {
            notEmpty: {
              message: 'This field is required'
            }
          }
        },
        street_num: {
          validators: {
            notEmpty: {
              message: 'This field is required'
            }
          }
        }
        // int_num: {
        //   validators: {
        //     notEmpty: {
        //       message: 'This field is required'
        //     }
        //   }
        // },
        // floor: {
        //   validators: {
        //     notEmpty: {
        //       message: 'This field is required'
        //     }
        //   }
        // }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: function (field, ele) {
            // field is the field name & ele is the field element
            switch (field) {
              case 'rental_commune':
              case 'rental_address':
                return '.col-sm-12';
              default:
                return '.col-sm-4';
            }
          }
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // Jump to the next step when all fields in the current step are valid
      validationStepper.next();
    });

    // Price Details
    const FormValidation5 = FormValidation.formValidation(wizardPropertyListingFormStep5, {
      fields: {
        // * Validate the fields here based on your requirements
        guest_email: {
          validators: {
            notEmpty: {
              message: 'Please add the guest emails'
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
          rowSelector: '.col-md-12'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // You can submit the form
      // wizardPropertyListingForm.submit()
      // or send the form data to server via an Ajax request
      // To make the demo simple, I just placed an alert
      // alert('Submitted..!!');
      var formData = new FormData($('#wizard-property-listing-form')[0]);
      $.ajax({
        type: 'POST',
        url: $('wizard-property-listing-form').attr('action'), // The form's action attribute
        data: formData,
        processData: false, // Required for FormData
        contentType: false, // Required for FormData
        success: function (response) {
          // Handle success
          console.log('Form submitted successfully');
          console.log(response);
          if (response && response.url) {
            window.location.href = response.url;
          }
          // You can redirect or show a success message here
        },
        error: function (xhr, status, error) {
          // Handle errors
          console.log('Submission failed');
          console.log(error);
        }
      });
    });

    wizardPropertyListingNext.forEach(item => {
      item.addEventListener('click', event => {
        // When click the Next button, we will validate the current step
        switch (validationStepper._currentIndex) {
          case 0:
            FormValidation1.validate();
            break;

          case 1:
            FormValidation2.validate();
            break;

          case 2:
            FormValidation3.validate();
            break;

          case 3:
            FormValidation4.validate();
            break;

          case 4:
            FormValidation5.validate();
            break;

          default:
            break;
        }
      });
    });

    wizardPropertyListingPrev.forEach(item => {
      item.addEventListener('click', event => {
        switch (validationStepper._currentIndex) {
          case 4:
            validationStepper.previous();
            break;

          case 3:
            validationStepper.previous();
            break;

          case 2:
            validationStepper.previous();
            break;

          case 1:
            validationStepper.previous();
            break;

          case 0:

          default:
            break;
        }
      });
    });
  }

  // Email List suggestion
  //------------------------------------------------------
  // generate random whitelist items (for the demo)
  let randomStringsArr = Array.apply(null, Array(100)).map(function () {
    return (
      Array.apply(null, Array(~~(Math.random() * 10 + 3)))
        .map(function () {
          return String.fromCharCode(Math.random() * (123 - 97) + 97);
        })
        .join('') + '@gmail.com'
    );
  });

  const tagifyBasicEl = document.querySelector('#guest_email');

  const TagifyBasic = new Tagify(tagifyBasicEl, {
    delimiters: ',| |\\n', // Allow comma, space, and newline as delimiters
    pattern:
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    placeholder: 'Enter email addresses', // Placeholder for the input
    maxTags: 20,
    transformTag: function (tagData) {
      tagData.value = tagData.value.trim(); // Remove unnecessary spaces
      return tagData;
    }
  });

  // Handle paste events to clean and process email addresses
  tagifyBasicEl.addEventListener('paste', function (e) {
    e.preventDefault();
    const pastedData = e.clipboardData.getData('text');

    // Split by spaces, commas, or newlines and remove "mailto:"
    const emails = pastedData
      .split(/[\s,]+/) // Split by spaces, commas, or newlines
      .map(email => email.replace(/^mailto:/, '').trim()) // Remove "mailto:" and trim
      .filter(email => email.length > 0); // Remove empty entries

    TagifyBasic.addTags(emails); // Add all valid emails as tags
  });

  const selectPicker = $('.selectpicker'),
    select2 = $('.select2'),
    select2Icons = $('.select2-icons');

  // Bootstrap Select
  // --------------------------------------------------------------------
  if (selectPicker.length) {
    selectPicker.selectpicker();
  }

  // Select2
  // --------------------------------------------------------------------

  // Default
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }

  // Select2 Icons
  if (select2Icons.length) {
    // custom template to render icons
    function renderIcons(option) {
      if (!option.id) {
        return option.text;
      }
      var $icon = "<i class='" + $(option.element).data('icon') + " me-2'></i>" + option.text;

      return $icon;
    }
    select2Icons.wrap('<div class="position-relative"></div>').select2({
      dropdownParent: select2Icons.parent(),
      templateResult: renderIcons,
      templateSelection: renderIcons,
      escapeMarkup: function (es) {
        return es;
      }
    });
  }

  function toggleRentalPropertyPanel() {
    const selectedProperty = $('#property_id').val();

    // Show panel if either condition is met
    if (selectedProperty) {
      $('#rental_property_panel').removeClass('d-none');
      $('#rental_property_next_btn').removeClass('disabled');

      if (selectedProperty) {
        // Get the data attributes of the selected property
        const selectedOption = $('#property_id option:selected');
        $('#rental_commune').val(selectedOption.data('rental_commune'));
        $('#rental_address').val(selectedOption.data('rental_address'));
        $('#street_num').val(selectedOption.data('street_num'));
        $('#int_num').val(selectedOption.data('int_num'));
        $('#floor').val(selectedOption.data('floor'));
      } else {
        // Clear the fields if "Create a New Property" is checked
        $('#rental_commune').val('');
        $('#rental_address').val('');
        $('#street_num').val('');
        $('#int_num').val('');
        $('#floor').val('');
      }
    } else {
      $('#rental_property_panel').addClass('d-none');
    }
  }
  $('#property_id').on('change', function () {
    $('#rental_commune').val('');
    $('#rental_address').val('');
    $('#street_num').val('');
    $('#int_num').val('');
    $('#floor').val('');

    if ($(this).val() === 'new') {
      $('#offcanvasAddProperty').offcanvas('show');
      $('#rental_property_panel').addClass('d-none');
      $('#property_id').val('').trigger('change');
    } else {
      toggleRentalPropertyPanel();
    }
  });

  // validating form and updating user's data
  const addNewPropertyForm = document.getElementById('addNewPropertyForm');

  // user form validation
  const fv = FormValidation.formValidation(addNewPropertyForm, {
    fields: {
      rental_commune: {
        validators: {
          notEmpty: {
            message: 'Please enter rental commune name'
          }
        }
      },
      rental_address: {
        validators: {
          notEmpty: {
            message: 'Please enter rental address'
          }
        }
      },
      street_num: {
        validators: {
          notEmpty: {
            message: 'Please enter street num'
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        // Use this for enabling/changing valid/invalid class
        eleValidClass: '',
        rowSelector: function (field, ele) {
          // field is the field name & ele is the field element
          return '.mb-6';
        }
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      // Submit the form when all fields are valid
      // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  }).on('core.form.valid', function () {
    // adding or updating user when form successfully validate
    $.ajax({
      data: $('#addNewPropertyForm').serialize(),
      url: `${baseUrl}properties/store`,
      type: 'POST',
      success: function (response) {
        if (response.success) {
          $('#property_id').append(
            `<option value="${response.data.id}"
              data-rental_commune="${response.data.rental_commune}"
              data-rental_address="${response.data.rental_address}"
              data-street_num="${response.data.street_num}"
              data-int_num="${response.data.int_num}"
              data-floor="${response.data.floor}"
              selected>
              ${response.data.rental_commune}, ${response.data.rental_address}, ${response.data.street_num}, ${response.data.int_num}, ${response.data.floor}
            </option>`
          );
          $('#addNewPropertyForm')[0].reset();
          $('#offcanvasAddProperty').offcanvas('hide');
          toggleRentalPropertyPanel();
          toastr['success'](`Property is created Successfully`, 'Property Creation');
        }
      },
      error: function (err) {
        $('#property_id').val('');
        $('#offcanvasAddProperty').offcanvas('hide');
        toastr['error'](`Same property is existed`, 'Property Creation');
      }
    });
  });

  // Event listener for the checkbox
  $('#owner_save_chk').on('change', function () {
    $('#owner_save').val($('#owner_save_chk').is(':checked') ? 1 : 0);
  });
  // $('#property_new_chk').on('change', function () {
  //   $('#property_new').val($('#property_new_chk').is(':checked') ? 1 : 0);
  // });
})();

let homeaddressField, birthCityField, birthCountryField, rentalCommuneField, rentalAddressField;
let autocomplete, autocompleteBithCity, autocompleteBithCountry, autocompleteRentalCommune, autocompleteRentalAddress;

function initAutocomplete() {
  homeaddressField = document.querySelector('#home_address');
  birthCityField = document.querySelector('#birth_city');
  birthCountryField = document.querySelector('#birth_country');
  rentalCommuneField = document.querySelector('#rental_commune');
  rentalAddressField = document.querySelector('#rental_address');

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

  // autocompleteRentalCommune = new google.maps.places.Autocomplete(rentalCommuneField, {
  //   componentRestrictions: { country: ["it"] },
  //   fields: ["address_components", "geometry"],
  //   types: ["address"],
  // });
  // autocompleteRentalCommune.addListener("place_changed", fillInRentalComune);

  autocompleteRentalAddress = new google.maps.places.Autocomplete(rentalAddressField, {
    componentRestrictions: { country: ['it'] },
    fields: ['address_components', 'geometry'],
    types: ['address']
  });
  // autocompleteRentalAddress.addListener("place_changed", fillInRentalAddress);

  let rentalAddressModalField = document.querySelector('#add-rental_address');
  if (rentalAddressModalField) {
    let autocompleteRentalAddressModal = new google.maps.places.Autocomplete(rentalAddressModalField, {
      componentRestrictions: { country: ['it'] },
      fields: ['address_components', 'geometry'],
      types: ['address']
    });
  }
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
function fillInRentalComune() {
  const place = autocompleteRentalCommune.getPlace();
  let address1 = '';

  for (const component of place.address_components) {
    // @ts-ignore remove once typings fixed
    const componentType = component.types[0];
    //console.log(component);
    switch (componentType) {
      case 'street_number': {
        address1 = `${component.long_name} ${address1}`;
        document.querySelector('#street_num').value = component.long_name;
        break;
      }

      case 'route': {
        address1 += component.long_name;
        break;
      }
    }
  }

  rentalCommuneField.value = address1;
}

window.onload = initAutocomplete;
