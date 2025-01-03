/**
 * Page User List
 */

'use strict';

// Datatable (jquery)
$(function () {
  if ($('.select2').length) {
    $('.select2').each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Select value',
        dropdownParent: $this.parent()
      });
    });
  }

  // Delete Record
  $(document).on('click', '.send-email', function () {
    var task_id = $(this).data('id'),
      url = $(this).data('url'),
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
          type: 'POST',
          url: url, //`${baseUrl}users/${user_id}`,
          success: function () {
            // dt_user.draw();
            $('.badge').attr('class', 'badge px-2 bg-label-warning text-capitalized');
            $('.badge').html('Waiting');
            // success sweetalert
            Swal.fire({
              icon: 'success',
              title: 'Sent!',
              text: 'We send email to guests!',
              customClass: {
                confirmButton: 'btn btn-success'
              }
            }).then(() => {
              location.reload();
            });
          },
          error: function (error) {
            console.log(error);
            Swal.fire({
              title: 'Failed',
              text: 'The Email was not sent!',
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
          text: 'The Email is not sent!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.cancel-task', function () {
    var task_id = $(this).data('id'),
      url = $(this).data('url'),
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
          type: 'POST',
          url: url, //`${baseUrl}users/${user_id}`,
          success: function () {
            // dt_user.draw();
            $('.badge').attr('class', 'badge px-2 bg-label-danger text-capitalized');
            $('.badge').html('Cancelled');
          },
          error: function (error) {
            console.log(error);
          }
        });

        // success sweetalert
        Swal.fire({
          icon: 'success',
          title: 'Sent!',
          text: 'The task was deleted!',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
        window.location.href = `${baseUrl}tasks`;
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Deleted',
          text: 'The task is not deleted!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });

  $(document).on('click', '.send-pec-email', function () {
    var task_id = $(this).data('id'),
      url = $(this).data('url'),
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
          type: 'POST',
          url: url, //`${baseUrl}users/${user_id}`,
          data: {
            police_station_id: $('#police_station_id').val()
          },
          success: function (result) {
            // dt_user.draw();
            $('.badge').attr('class', 'badge px-2 bg-label-warning text-capitalized');
            $('.badge').html('Waiting');
            // success sweetalert
            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Sent!',
                text: 'We send email to the selected Police Station!',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Failed',
                text: 'The Email was not sent!',
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
              text: 'The Email was not sent!',
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
          text: 'The Email is not sent!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
  $(document).on('click', '.generate-pdf', function () {
    var task_id = $(this).data('id'),
      url = $(this).data('url'),
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
      confirmButtonText: 'Yes, generate it!',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.value) {
        Swal.fire({
          title: 'Generating...',
          text: 'Please wait while we generate the pdf.',
          allowOutsideClick: false,
          allowEscapeKey: false,
          showConfirmButton: false, // Hide the confirm button
          showCancelButton: false, // Hide the cancel button
          didOpen: () => {
            Swal.showLoading(); // Show the loading spinner
          }
        });
        $.ajax({
          type: 'POST',
          url: url, //`${baseUrl}users/${user_id}`,
          success: function (result) {
            // dt_user.draw();
            $('.badge').attr('class', 'badge px-2 bg-label-warning text-capitalized');
            $('.badge').html('Waiting');
            // success sweetalert
            if (result.success) {
              Swal.fire({
                icon: 'success',
                title: 'Generated!',
                text: 'We generate the pdf!',
                customClass: {
                  confirmButton: 'btn btn-success'
                }
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                title: 'Failed',
                text: 'The PDF was not generated!',
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
              text: 'The PDF was not generated!',
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
          text: 'The PDF was not generated!',
          icon: 'error',
          customClass: {
            confirmButton: 'btn btn-success'
          }
        });
      }
    });
  });
});
