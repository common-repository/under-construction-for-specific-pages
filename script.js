jQuery(document).ready(function($){

    //jQuery('#summernote').summernote();

    jQuery("#savedata").click( function(e) {
        var page_id = $('#page_id').val();
        var startdatetime = $('#startdatetime').val();
        var enddatetime = $('#enddatetime').val();
        if(page_id != '' && startdatetime != '' && enddatetime != '' ) { // && editorname != ''
            $('.wqsubmit_message').html('');
            var fd = new FormData(document.getElementById("setUnderconstruction"));
            var action = 'underconstructionaction';
            fd.append("action", action);

            var myContent = tinymce.get("my_editor_content").getContent();
            var content = tinymce.activeEditor.getContent();
            fd.append("contentText", myContent);
            $.ajax({
                data: fd,
                type: 'POST',
                url: ajax_var.ajaxurl,
                contentType: false,
                   cache: false,
                   processData:false,
                success: function(response) {
                    if (response == 1) {
                        $('.wqsubmit_message').html('<span class="alert alert-success"> Data Has Inserted Successfully </span>');
                        setTimeout(function() { location.reload(); }, 3500);
                    } else if(response == 2){
                        $('.wqsubmit_message').html('<span class="alert alert-danger"> Data Not Saved </span>');
                    } else if(response == 3){
                        $('.wqsubmit_message').html('<span class="alert alert-info"> Selected page is already set! </span>');
                    }
                    //$('.wqsubmit_message').html(response);
                }
            });
        } else {
            $('.wqsubmit_message').html('<span class="alert alert-danger"> Please select start and end date.</span>');
          return false;
        }
    });

    //delete data
    jQuery(".deletedata").click( function(e) {
      var uid = this.getAttribute("data-ucid");
      if (confirm('Are you sure to delete this?')) {
        $('#msg').html('');
        var fd = new FormData(document.getElementById("formaction_"+uid));
        var action = 'delete_data_unid';
        fd.append("action", action);
        $.ajax({
              data: fd,
              type: 'POST',
              url: ajax_var.ajaxurl,
              contentType: false,
                 cache: false,
                 processData:false,
              success: function(res) {
                $('#msg').html('<span class="alert alert-success"> Under Construction Removed Successfully </span>');
                $('#user_'+uid).remove();
                setTimeout(function() { location.reload(); }, 3500);
              }
        });
      }
    });

    //open edit modal popup
    jQuery(".editdata").click( function(e) {
      var uid = this.getAttribute("data-editucid");
        $('#msg').html('');
        $("#editid").val(uid); 
        //alert(uid);
        $('#editDataModal_'+uid).modal('toggle');
    });

    //update data
    jQuery(".updatedata").click( function(e) {
        var upid = this.getAttribute("data-updateid");
        //alert(uid);
        var updatedataform = new FormData(document.getElementById("editForm_"+upid));
        var action = 'updatedata_id';
        updatedataform.append("action", action);

        var content = tinymce.activeEditor.getContent();
        updatedataform.append("content", content);

        $.ajax({
              data: updatedataform,
              type: 'POST',
              url: ajax_var.ajaxurl,
              contentType: false,
                 cache: false,
                 processData:false,
              success: function(res) {
                if (res == 1) {
                    $('.wqsubmit_message').html('<span class="alert alert-success"> Data Has Updated Successfully </span>');
                    setTimeout(function() { location.reload(); }, 3500);
                } else {
                    $('.wqsubmit_message').html('<span class="alert alert-danger"> Data Not Updated </span>');
                }
            }
        });
    });
});
