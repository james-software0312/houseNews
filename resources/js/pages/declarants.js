/**
 * Page Declarant List
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration for table
  const flatpickrRange = document.querySelector('.flatpickr');
  var dt_user_table = $('.datatables-declarants'),
    select2 = $('.select2'),
    userView = baseUrl + 'app/user/view/account',
    offCanvasForm = $('#offcanvasAddUser');

  if (select2.length) {
    var $this = select2;
    $this.wrap('<div class="position-relative"></div>').select2({
      placeholder: 'Select Country',
      dropdownParent: $this.parent()
    });
  }

  if (flatpickrRange) {
    flatpickrRange.flatpickr({
      dateFormat: 'd M, Y',
      disableMobile: true,
      defaultDate: flatpickrRange.value
    });
  }

  // declarants datatable
  if (dt_user_table.length) {
    var dt_user = dt_user_table.DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: baseUrl + 'declarants/getlist'
      },
      columns: [
        // columns according to JSON
        { data: '' },
        // { data: 'id' },
        { data: 'name' },
        { data: 'pec_email' },
        { data: 'action' }
      ],
      columnDefs: [
        {
          // For Responsive
          className: 'control',
          searchable: false,
          orderable: false,
          responsivePriority: 2,
          targets: 0,
          render: function (data, type, full, meta) {
            return '';
          }
        },
        // {
        //   searchable: false,
        //   orderable: false,
        //   targets: 1,
        //   render: function (data, type, full, meta) {
        //     return `<span>${full.fake_id}</span>`;
        //   }
        // },
        {
          targets: 1,
          responsivePriority: 4,
          render: function (data, type, full, meta) {
            var $full_name = full['full_name'];
            var $avatar = full['avatar'];

            // For Avatar badge
            var stateNum = Math.floor(Math.random() * 6);
            var states = ['success', 'danger', 'warning', 'info', 'dark', 'primary', 'secondary'];
            var $state = states[stateNum],
              $full_name = full['full_name'],
              $initials = $full_name.match(/\b\w/g) || [],
              $output;
            $initials = (($initials.shift() || '') + ($initials.pop() || '')).toUpperCase();
            $output = '<span class="avatar-initial rounded-circle bg-label-' + $state + '">' + $initials + '</span>';
            if ($avatar && $avatar != '') {
              $output = '<img src="' + $avatar + '" alt="" class="w-px-40 h-auto rounded-circle">';
            }
            // Creates full output for row
            var $row_output =
              '<div class="d-flex justify-content-start align-items-center user-name">' +
              '<div class="avatar-wrapper">' +
              '<div class="avatar avatar-sm me-4">' +
              $output +
              '</div>' +
              '</div>' +
              '<div class="d-flex flex-column">' +
              '<span class="fw-medium">' +
              $full_name +
              '</span>' +
              '</div>' +
              '</div>';
            return $row_output;
          }
        },
        {
          // pec_email
          targets: 2,
          render: function (data, type, full, meta) {
            var $pec_email = full['pec_email'];

            return '<span class="user-pec_email">' + $pec_email + '</span>';
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-flex align-items-center gap-50">' +
              `<button class="btn btn-sm btn-icon edit-record" data-id="${full['id']}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><i class="bx bx-edit"></i></button>` +
              `<button class="btn btn-sm btn-icon delete-record" data-id="${full['id']}"><i class="bx bx-trash"></i></button>` +
              // '<button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>' +
              // '<div class="dropdown-menu dropdown-menu-end m-0">' +
              // '<a href="' +
              // userView +
              // '" class="dropdown-item">View</a>' +
              // '<a href="javascript:;" class="dropdown-item">Suspend</a>' +
              // '</div>' +
              '</div>'
            );
          }
        }
      ],
      order: [[1, 'desc']],
      dom:
        '<"row"' +
        '<"col-md-2"<"ms-n2"l>>' +
        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0"fB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [7, 10, 20, 50, 70, 100], //for length of menu
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Search Declarant',
        info: 'Displaying _START_ to _END_ of _TOTAL_ entries',
        paginate: {
          next: '<i class="bx bx-chevron-right bx-sm"></i>',
          previous: '<i class="bx bx-chevron-left bx-sm"></i>'
        }
      },
      // Buttons with Dropdown
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-secondary dropdown-toggle mx-4',
          text: '<i class="bx bx-export me-2 bx-sm"></i>Export',
          buttons: [
            {
              extend: 'print',
              title: 'Declarants',
              text: '<i class="bx bx-printer me-2" ></i>Print',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-first_name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              },
              customize: function (win) {
                //customize print view for dark
                $(win.document.body)
                  .css('color', config.colors.headingColor)
                  .css('border-color', config.colors.borderColor)
                  .css('background-color', config.colors.body);
                $(win.document.body)
                  .find('table')
                  .addClass('compact')
                  .css('color', 'inherit')
                  .css('border-color', 'inherit')
                  .css('background-color', 'inherit');
              }
            },
            {
              extend: 'csv',
              title: 'Declarants',
              text: '<i class="bx bx-file me-2" ></i>Csv',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be print
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-first_name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'excel',
              text: '<i class="bx bxs-file-export me-2"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-first_name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'pdf',
              title: 'Declarants',
              text: '<i class="bx bxs-file-pdf me-2"></i>Pdf',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be display
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-first_name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            },
            {
              extend: 'copy',
              title: 'Declarants',
              text: '<i class="bx bx-copy me-2" ></i>Copy',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5],
                // prevent avatar to be copy
                format: {
                  body: function (inner, coldex, rowdex) {
                    if (inner.length <= 0) return inner;
                    var el = $.parseHTML(inner);
                    var result = '';
                    $.each(el, function (index, item) {
                      if (item.classList !== undefined && item.classList.contains('user-first_name')) {
                        result = result + item.lastChild.firstChild.textContent;
                      } else if (item.innerText === undefined) {
                        result = result + item.textContent;
                      } else result = result + item.innerText;
                    });
                    return result;
                  }
                }
              }
            }
          ]
        },
        {
          text: '<i class="bx bx-plus bx-sm me-0 me-sm-2"></i><span class="d-none d-sm-inline-block">Add New</span>',
          className: 'add-new btn btn-primary',
          attr: {
            'data-bs-toggle': 'offcanvas',
            'data-bs-target': '#offcanvasAddUser'
          }
        }
      ],
      // For responsive popup
      responsive: {
        details: {
          display: $.fn.dataTable.Responsive.display.modal({
            header: function (row) {
              var data = row.data();
              return 'Details of ' + data['full_name'];
            }
          }),
          type: 'column',
          renderer: function (api, rowIdx, columns) {
            var data = $.map(columns, function (col, i) {
              return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                ? '<tr data-dt-row="' +
                    col.rowIndex +
                    '" data-dt-column="' +
                    col.columnIndex +
                    '">' +
                    '<td>' +
                    col.title +
                    ':' +
                    '</td> ' +
                    '<td>' +
                    col.data +
                    '</td>' +
                    '</tr>'
                : '';
            }).join('');

            return data ? $('<table class="table"/><tbody />').append(data) : false;
          }
        }
      }
    });
    // To remove default btn-secondary in export buttons
    $('.dt-buttons > .btn-group > button').removeClass('btn-secondary');
  }

  // Delete Record
  $(document).on('click', '.delete-record', function () {
    var declarant_id = $(this).data('id'),
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
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        // delete the data
        $.ajax({
          type: 'DELETE',
          url: `${baseUrl}declarants/${declarant_id}`,
          success: function () {
            dt_user.draw();
          },
          error: function (error) {
            console.log(error);
          }
        });

        toastr['success'](`The declarant has been deleted`, 'Declarant');
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        // toastr['error'](`The declarant is not deleted`, 'Declarant');
      }
    });
  });

  // edit record
  $(document).on('click', '.edit-record', function () {
    $('#uploadedAvatar').attr('src', '/assets/img/avatar.png');
    $('#upload').val('');
    var declarant_id = $(this).data('id'),
      dtrModal = $('.dtr-bs-modal.show');

    // hide responsive modal in small screen
    if (dtrModal.length) {
      dtrModal.modal('hide');
    }

    // changing the title of offcanvas
    $('#offcanvasAddUserLabel').html('Edit Declarant');

    // get data
    $.get(`${baseUrl}declarants\/${declarant_id}\/edit`, function (data) {
      $('#declarant_id').val(data.id);
      $('#first_name').val(data.first_name);
      $('#last_name').val(data.last_name);
      $('#pec_email').val(data.pec_email);
      $('#home_address').val(data.address);
      if (data.birthday) {
        const dateObj = new Date(data.birthday);
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const formattedDate = `${dateObj.getDate()} ${monthNames[dateObj.getMonth()]}, ${dateObj.getFullYear()}`;
        $('#birthday').val(formattedDate);
      }
      $('#birth_city').val(data.birth_city);
      $('#birth_country').val(data.birth_country);
      if (data.avatar) $('#uploadedAvatar').attr('src', data.avatar);
      $('#is_owned').prop('checked', data.is_owned == 1);
    });
  });

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
  // changing the title
  $('.add-new').on('click', function () {
    $('#declarant_id').val(''); //reseting input field
    $('#offcanvasAddUserLabel').html('Add Declarant');
    $('#uploadedAvatar').attr('src', '/assets/img/avatar.png');
    $('#upload').val('');
  });

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // validating form and updating user's data
  const addNewUserForm = document.getElementById('addNewUserForm');

  // user form validation
  const fv = FormValidation.formValidation(addNewUserForm, {
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
            message: 'Please enter your pec email'
          },
          emailAddress: {
            message: 'The value is not a valid email address'
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
    const formData = new FormData(addNewUserForm);
    $.ajax({
      data: formData,
      url: `${baseUrl}declarants/store`,
      type: 'POST',
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.success) {
          toastr['success'](response.message, 'Declarant');
          dt_user.draw();
          offCanvasForm.offcanvas('hide');
        } else {
          toastr['error'](response.message, 'Declarant');
        }
      },
      error: function (err) {
        offCanvasForm.offcanvas('hide');
        toastr['error'](`We found error in your process`, 'Declarant');
      }
    });
  });

  // clearing form data when offcanvas hidden
  offCanvasForm.on('hidden.bs.offcanvas', function () {
    fv.resetForm(true);
  });

  const phoneMaskList = document.querySelectorAll('.phone-mask');

  // Phone Number
  if (phoneMaskList) {
    phoneMaskList.forEach(function (phoneMask) {
      new Cleave(phoneMask, {
        phone: true,
        phoneRegionCode: 'US'
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

// $('#offcanvasAddUser').on('shown.bs.modal', function () {
//   initAutocomplete();
// });
// $('#offcanvasAddUser').on('shown.bs.modal', function () {
//   setTimeout(initAutocomplete, 100);
// });

window.onload = initAutocomplete;
