/*
Initialize the datables for leads/form submissions/proposals admin pages
*/


jQuery(document).ready(function($) {
	
    $('#companies-list').DataTable({
		dom : 'lf<"responsive_table"t>ipr',
		"columnDefs": [
            { 
                "orderable": false, 
                "targets": [0,1,8],
            }
        ],
		"order": [],
	});
	$('#contact-list').DataTable({
		dom : 'lf<"responsive_table"t>ipr',
		"columnDefs": [
            { 
                "orderable": false, 
                "targets": [0,1,8],
            }
        ],
		"order": [],
	});
	$('#proposals-list').DataTable({
		dom : 'lf<"responsive_table"t>ipr',
		"columnDefs": [
            { 
                "orderable": false, 
                "targets": [0,1,9],
            }
        ],
		"order": [],
	});
	
	//For Details 
    $(document).on('click', '.custom-view-details', function(e){
        e.preventDefault();
        var entryid 	=  $(this).data('id');
		var table_name  =  $(this).data('tablename');
		jQuery('.custom-admin-loader').css("display", "flex");
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action    : 'get_entry_details',
                id        : entryid,
				tableName : table_name
            },
            success: function(response){
				const res = JSON.parse(response);
				if(res.status){
					jQuery('#custom-view-details-popup').html('');
					const html = res.html;
					jQuery('#custom-view-details-popup').html(html);
					jQuery('#custom-view-details-popup').show();
				}else{
					alert(res.msg);
					location.reload();
				}
				jQuery('.custom-admin-loader').hide();
            }
        });
    });

    // Close popup when the close button is clicked
    $(document).on('click', 'div#custom-view-details-popup span.close-popup', function(){
        $('#custom-view-details-popup').hide();
    });
	
	$(document).on('click', 'div#custom-entry-edit-details-popup span.close-popup', function(){
        $('div#custom-entry-edit-details-popup').hide();
    });
	
	//Model Edit
	$(document).on('click', '.edit-details', function(e){
        e.preventDefault();

        var entryid     =  $(this).data('id');
		var table_name  =  $(this).data('tablename');
		jQuery('.custom-admin-loader').css("display", "flex");
        // Fetch post details via AJAX
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action     : 'get_entry_details_edit',
                entryid    : entryid,
				tableName  : table_name
            },
            success: function(response) {
                const res = JSON.parse(response);
				if(res.status){
					jQuery('div#custom-entry-edit-details-popup').html('');
					const html = res.html;
					jQuery('div#custom-entry-edit-details-popup').html(html);
					jQuery('div#custom-entry-edit-details-popup').show();
				}else{
					alert(res.msg);
					location.reload();
				}
				jQuery('.custom-admin-loader').hide();
            }
        });
    });
	
	
	// Delete Entries Process
    $(document).on('click', '.action_btn .delete-entry', function(e) {
        e.preventDefault();
        var entryId      =  $(this).data('id');
		var table_name   =  $(this).data('tablename');
        if (confirm('Are you sure you want to delete this entry?')) {
			jQuery('.custom-admin-loader').css("display", "flex");
            $.ajax({
                url  : ajaxurl,
                type : 'POST',
                data : {
                    action       : 'delete_entry_process',
                    id           : entryId,
					tableName    : table_name
                },
                success: function(response) {
					const res = JSON.parse(response)
                    if(res.status){
                        alert(res.msg);
                        location.reload();
                    }else{
                        alert('Error deleting entry: ' + res.msg);
						location.reload();
                    }
					jQuery('.custom-admin-loader').hide();
                }
            });
        }
    });

    // Close popup when the close button is clicked
    $(document).on('click', '.close-popup', function() {
        $('#details-popup').hide();
		$('#contact-popup').hide();
		$('#proposal-popup').hide();
    });

    // Close popup when clicking outside the popup content
    $(document).on('click', '#details-popup', function(e) {
        if ($(e.target).is('#details-popup')) {
            $('#details-popup').hide();
        }
    });
	
	//For Bulk Delete 
	$('#custom-select-all-companies').on('change', function() {
        // Set the checked state of all company checkboxes to match the "Select All" checkbox
        $('.custom-hth-company-checkbox').prop('checked', this.checked);
    });
	
	$('.custom-hth-company-checkbox').on('change', function() {
        if (!$(this).prop('checked')) {
            $('#custom-select-all-companies').prop('checked', false);
        } else if ($('.custom-hth-company-checkbox:checked').length === $('.custom-hth-company-checkbox').length) {
            // If all individual checkboxes are checked, check the "Select All" checkbox
            $('#custom-select-all-companies').prop('checked', true);
        }
    });
	
	//Edit Comapany Entry
	$(document).on('click', 'button#popup-edit-company-list-btn', function(e){
		e.preventDefault();
		jQuery('button#popup-edit-company-list-btn').html('Please Wait...');
		 var data = new FormData(jQuery("#popup-companies-list-form")[0]);
		 data.append('action', 'hth_edit_company_entry_process');
		jQuery.ajax({
			url         :   ajaxurl,
			type        :   'POST',
			data        :   data,
			contentType : 	false,
			processData	: 	false,
			success     : function(response){
				const ress = JSON.parse(response);
				if(ress.status){
					alert(ress.msg);
					location.reload();
				}else{
					alert(ress.msg);
					location.reload();
				}
			},
			error: function(error){
				console.log('AJAX Error:', error);
				jQuery('button#popup-edit-company-list-btn').html('Save Changes');
			}
		});
	});
	
	//Edit Contact Us Entry
	$(document).on('click', 'button#popup-edit-contact-list-btn', function(e){
		e.preventDefault();
		jQuery('button#popup-edit-contact-list-btn').html('Please Wait...');
		 var data = new FormData(jQuery("form#popup-contact-list-form")[0]);
		 data.append('action', 'hth_edit_contactus_entry_process');
		jQuery.ajax({
			url         :   ajaxurl,
			type        :   'POST',
			data        :   data,
			contentType : 	false,
			processData	: 	false,
			success     : function(response){
				const ress = JSON.parse(response);
				if(ress.status){
					alert(ress.msg);
					location.reload();
				}else{
					alert(ress.msg);
					location.reload();
				}
			},
			error: function(error){
				console.log('AJAX Error:', error);
				jQuery('button#popup-edit-contact-list-btn').html('Save Changes');
			}
		});
	});
	
	//Edit Proposal Entry
	$(document).on('click', 'button#popup-edit-proposale-list-btn', function(e){
		e.preventDefault();
		jQuery('button#popup-edit-proposale-list-btn').html('Please Wait...');
		 var data = new FormData(jQuery("form#popup-proposals-list-form")[0]);
		 data.append('action', 'hth_edit_proposal_entry_process');
		jQuery.ajax({
			url         :   ajaxurl,
			type        :   'POST',
			data        :   data,
			contentType : 	false,
			processData	: 	false,
			success     : function(response){
				const ress = JSON.parse(response);
				if(ress.status){
					alert(ress.msg);
					location.reload();
				}else{
					alert(ress.msg);
					location.reload();
				}
			},
			error: function(error){
				console.log('AJAX Error:', error);
				jQuery('button#popup-edit-proposale-list-btn').html('Save Changes');
			}
		});
	});
	
});