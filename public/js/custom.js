var csrf_token = $('meta[name=csrf-token]').attr('content');
$(document).ready( function () {
    $("#add_edit_user_modal,#view_user_modal,#add_edit_category_modal,#import_excel").modal({
      show:false,
      backdrop:'static'
    });

    // Multiple delete checkbox click event
    $('#example1').on('change', 'tbody,thead input.dt-checkboxes', function () {
        var rows_selected = $('#example1').DataTable().column(0).checkboxes.selected();
        if(rows_selected.length){
          $("#multiple_delete_btn").prop('disabled', false);
        } else {
          $("#multiple_delete_btn").prop('disabled', true);
        }
    });

    $('#frm-example').on('change', 'tbody,thead input.dt-checkboxes', function () {
        var rows_selected = $('.data-table').DataTable().column(0).checkboxes.selected();
        if(rows_selected.length){
          $("#multiple_delete_btn").prop('disabled', false);
        } else {
          $("#multiple_delete_btn").prop('disabled', true);
        }
    });
});

function load_preview_image(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#preview_div").show();
            $('#image_preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    } else {
      $("#preview_div").hide();
    }
}

function Validateusername(evt) {
  var keyCode = (evt.which) ? evt.which : evt.keyCode
  if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && (keyCode < 48 || keyCode > 58) && keyCode != 46 && keyCode != 95 && keyCode != 13)
      return false;
  else
      return true;
}

// reload datatables
function reload_data(){
    $('.data-table').DataTable().ajax.reload();
}

