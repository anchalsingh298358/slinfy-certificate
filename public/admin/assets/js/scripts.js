//update user status
jQuery(document).on('click', ".update_status", function () {
    var id = $(this).attr('data-id');
    var title = $(this).attr('data-title');
    var url = $(this).attr('data-url');
    var icon = $(this).attr('data-icon');
    var success_msg = $(this).attr('data-success');
    var cancel_msg = $(this).attr('data-cancel');
    var data_table = $(this).attr('data-table');
    var body = 'Are you sure to change status?';

    swal({
        // title: title,
        text: body,
        icon: icon,
        buttons: true,
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.status == 1) {
                            swal(success_msg, {
                                icon: "success",
                            });

                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        } else if (response.status == 0) {
                            swal(response.message, {
                                icon: "warning",
                            });
                        }
                    }
                });
            } else {
                swal(cancel_msg);
                if ($(this).attr('data-status') == 0) {
                    $('#togle-' + id).prop('checked', false);
                } else {
                    $('#togle-' + id).prop('checked', true);
                }
            }
        });
});

//Delete Student
jQuery(document).on('click', ".delete-data", function () {
    var title = $(this).attr('data-title');
    var body = $(this).attr('data-body');
    var url = $(this).attr('data-url');
    var icon = $(this).attr('data-icon');
    var success_msg = $(this).attr('data-success');
    var cancel_msg = $(this).attr('data-cancel');

    swal({
        title: title,
        text: body,
        icon: icon,
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "DELETE",
                url: url,
                data: {},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    if (response.status == 1) {
                        swal(success_msg, {
                            icon: "success",
                        });

                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    } else if (response.status == 0) {
                        swal(response.message, {
                            icon: "warning",
                        });

                    }
                }
            });
        } else {
            swal(cancel_msg);
        }
    });
});


//show image after upload file
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-img-tag').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

jQuery(".image").change(function () {
    $('.profile-img-tag').show();
    readURL(this);
});

//Import file and get file name
jQuery(".import_file").change(function () {
    $('.upload_file').html($('input[type=file]').val().split('\\').pop());
});


//Float Number Validation
jQuery('.float_number').keypress(function (event) {
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});

//number validation
jQuery(".number").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        return false;
    }
});


//Import student form validation
jQuery('#import_student').validate({
    ignore: [],
    debug: false,
    rules: {
        import_student: {
            required: true,
        },
        session: {
            required: true,
        },
    }
});


//Technology form validation
jQuery('#technology-form').validate({
    ignore: [],
    debug: false,
    rules: {
        name: {
            required: true,
        }
    }
});


//course form validation
jQuery('#course-form').validate({
    ignore: [],
    debug: false,
    rules: {
        name: {
            required: true,
        }
    }
});


//Batch form validation
jQuery('#batch-form').validate({
    ignore: [],
    debug: false,
    rules: {
        name: {
            required: true,
        }
    }
});



//Student form validation
jQuery('#student-form').validate({
    ignore: [],
    debug: false,
    rules: {
        name: {
            required: true,
        },
        session: {
            required: true,
        },
        gender: {
            required: true,
        },
        father_name: {
            required: true,
        },
        mother_name: {
            required: true,
        },
        city: {
            required: true,
        },
        address: {
            required: true,
        },
        state: {
            required: true,
        },
        college_name: {
            required: true,
        },
        country_code: {
            required: true,
        },
        phone_number: {
            required: true,
            number : true,
            maxlength: 12
        },
        email: {
            required: true,
        },
        duration: {
            required: true,
        },
        technology: {
            required: true,
        },
        date_from: {
            required: true,
        },
        date_to: {
            required: true,
        },
    }
});




// Check all 
$('#checkall').click(function(){
  if($(this).is(':checked')){
     $('.delete_check').prop('checked', true);
  }else{
     $('.delete_check').prop('checked', false);
  }
});


//Delete All category Records
$('#delete_record').click(function(){

  var deleteids_arr = [];
  // Read all checked checkboxes
  $("input:checkbox[class=delete_check]:checked").each(function () {
     deleteids_arr.push($(this).val());
  });

  // Check checkbox checked or not
  if(deleteids_arr.length > 0){

     // Confirm alert
     // var confirmdelete = confirm("Once category is delete, all medicine and subcateogory will be deleted related to this category!");
     // if (confirmdelete == true) {
     //    $.ajax({
     //       method: 'get',
     //       url: BASE_URL +'/admin/category/delete_all',
     //       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     //       data: {deleteids_arr: deleteids_arr},
     //       success: function(response){
     //          location.reload(true);
     //       }
     //    });
     // }

     swal({
        title: 'Are you sure?',
        text: 'Once category is delete, all medicine and subcateogory will be deleted related to this category!',        
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
             method: 'get',
             url: BASE_URL +'/admin/category/delete_all',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             data: {deleteids_arr: deleteids_arr},
             success: function(response){
              console.log(response);

                location.reload(true);
             
             }
          });
        } else {
            swal({title: 'Your category is safe!'});
        }
    });
  }
  else
  {
    swal({
        title: 'Please, Select first any category!',
        showCancelButton: false,
        showConfirmButton: true,
        dangerMode: true,
    })
  }
});