jQuery(document).ready(function(){
    jQuery(document).on('input', 'input#itfirms-search-input', function(){
        var search = jQuery(this).val();
        jQuery.ajax({
            url     : itfirmsScriptData.ajaxUrl,
            type    : 'POST',
            data    : {
                action  : 'itfirms_search',
                search  : search,
            },
            success: function(response){
                const result = JSON.parse(response);
                if(result.output){
                    jQuery('#suggetions-list').html('');
                    jQuery('#suggetions-list').html(result.output);
                    jQuery('#itf-search-form').addClass('active');
                }else{
                    jQuery('#suggetions-list').html('');
                    jQuery('#itf-search-form').removeClass('active');
                }
            },
            error: function(xhr, status, error){
                console.error('AJAX Error:', status, error);
            }
        });
    });

    jQuery(document).on('input', 'input#itfirms-search-inputs', function(){
        var search = jQuery(this).val();
        jQuery.ajax({
            url     : itfirmsScriptData.ajaxUrl,
            type    : 'POST',
            data    : {
                action  : 'itfirms_search',
                search  : search,
            },
            success: function(response){
                const result = JSON.parse(response);
                if(result.output){
                    jQuery('#suggetions-lists').html('');
                    jQuery('#suggetions-lists').html(result.output);
                    jQuery('#itf-search-forms').addClass('active');
                }else{
                    jQuery('#suggetions-lists').html('');
                    jQuery('#itf-search-forms').removeClass('active');
                }
            },
            error: function(xhr, status, error){
                console.error('AJAX Error:', status, error);
            }
        });
    });
    //CONTACT FORM SUBMIT validation..
    
    jQuery('#itfirms-contact-form input[name="itf_contact_phone"], input[type="tel"], .numberOnly, input[name="company_contact"]').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    //CONTACT FORM SUBMIT..
    jQuery(document).on('click', '#itfirms-submit-contact-form-btn', function(e){
        e.preventDefault();
        var err = 0;
        var name = jQuery('input[name="itf_contact_name"]').val();
        jQuery('.error').remove();
        jQuery('.success-msg, .error-msg').remove();
        if(name == ''){
            jQuery('input[name="itf_contact_name"]').css('outline', '2px solid red');
			jQuery('#error_name').remove();
			jQuery('input[name="itf_contact_name"]').after('<span class="error" id="error_name" style="color:red; display:block;">Please fill out this field.</span>');
			jQuery('input[name="itf_contact_name"]').focus();
            err++;
            return false;
        }else{
            jQuery('input[name="itf_contact_name"]').css('outline', 'none');
            jQuery('#error_name').remove();
        }
        var email = jQuery('input[name="itf_contact_email"]').val();
        if(email == ''){
            jQuery('input[name="itf_contact_email"]').css('outline', '2px solid red');
			jQuery('#error_email').remove();
			jQuery('input[name="itf_contact_email"]').after('<span class="error" id="error_email" style="color:red; display:block;">Please fill out this field.</span>');
			jQuery('input[name="itf_contact_email"]').focus();
			err++;
            return false;
        }else{
            jQuery('input[name="itf_contact_email"]').css('outline', 'none');
            jQuery('#error_email').remove();
        }
        // else {            
        //     var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        //     if (!emailPattern.test(email)) {
        //         jQuery('input[name="itf_contact_email"]').css('outline', '2px solid red');
        //         jQuery('#error_email').remove();
        //         jQuery('input[name="itf_contact_email"]').after('<span class="error" id="error_email" style="color:red; display:block;">Please enter a valid email address.</span>');
        //         jQuery('input[name="itf_contact_email"]').focus();
        //         err++;
        //         return false;
        //     } else {
        //         jQuery('input[name="itf_contact_email"]').css('outline', 'none');
        //         jQuery('#error_email').remove();
        //     }
        // }
        var captcha = jQuery('#itf_contact_tcaptcha').val();
        var insert_captcha = jQuery('#itf_contact_captcha_ans').val();
        if(insert_captcha == ''){
            jQuery('.error').remove();
            jQuery('#itf_contact_captcha_ans').css('outline', '2px solid red');
            jQuery('#itf_contact_captcha_ans').closest('.input-field').after('<span class="error" id="error_captcha_blank" style="color:red; display:block;">Please fill out this field.</span>');            
            jQuery('#itf_contact_captcha_ans').focus();
            err++;
            return false;
        } else if(insert_captcha && insert_captcha!= captcha){
            jQuery('.error').remove();
            jQuery('#itf_contact_captcha_ans').css('outline', '2px solid red');
            jQuery('#itf_contact_captcha_ans').closest('.input-field').after('<span class="error" id="error_captcha_invalid" style="color:red; display:block;">Captcha is Invalid.</span>');            
            jQuery('#itf_contact_captcha_ans').focus();
            err++;
            return false;
        } else{
            jQuery('#itf_contact_captcha_ans').css('outline', 'none');
            jQuery('.error-msg').hide();
        }
        if(err == 0){
            jQuery('#itfirms-submit-contact-form-btn').html('Please Wait...');
            var data = new FormData(jQuery("#itfirms-contact-form")[0]);
            data.append('action', 'itfirms_contact_submit');
            jQuery.ajax({
                url         :   itfirmsScriptData.ajaxUrl,
                type        :   'POST',
                data        :   data,
                contentType : 	false,
                processData	: 	false,
                success     : function(response){
                    const result = JSON.parse(response);
                    console.log(result);
                    if(result.status){
                        jQuery('.error-msg').hide();
                        jQuery('#itfirms-submit-contact-form-btn').after('<span class="success-msg">'+result.msg+'</span>');
                        jQuery('#itfirms-submit-contact-form-btn').html('Submit');
                        setTimeout(function() {
                            location.reload();                            
                        }, 2000);
                    }else{
                        jQuery('#itfirms-submit-contact-form-btn').after('<span class="error-msg">'+result.msg+'</span>');
                        jQuery('#itfirms-submit-contact-form-btn').html('Submit');
                    }
                },
                error: function(error){
                    console.log('AJAX Error:', error);
                    jQuery('#itfirms-submit-contact-form-btn').html('Submit');
                }
            });
        }
    });
    // var debounceTimer;
    jQuery(document).on('input', '.itf-fields-change', function(){
        saveContactInfo();
    });

    // Debounce function
    function debounce(func, delay){
        var timer;
        return function(){
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                func.apply(context, args);
            }, delay);
        };
    }

    var saveContactInfo = debounce(function(){
        var data    = new FormData(jQuery("#itfirms-contact-form")[0]);
        data.append('action', 'itfirms_contact_submit');
        jQuery.ajax({
            url         :   itfirmsScriptData.ajaxUrl,
            type        :   'POST',
            data        :   data,
            contentType : 	false,
            processData	: 	false,
            success     : function(response){
                const result = JSON.parse(response);
                // if(result.status){
                //     if(result.edit_id){
                //         jQuery('input[name="itf_edit_id"]').val(result.edit_id);
                //     }
                // }else{
                //     //Silence is golden..
                // }
            },
            error: function(error){
                console.log('AJAX Error:', error);
            }
        });
    }, 1000);


    //Contact Page Contact Form
    jQuery(document).on('click', '#contactpage-submit-btn', function(e){
        var clientDate = new Date();
        var clientTime = clientDate.toLocaleString();
        jQuery('.recaptcha-error').remove();
          console.log("Browser's local time: " + clientTime);
        e.preventDefault();
        var err = 0;
        var name = jQuery('input[name="contact_name"]').val();
        if(name == ''){
            jQuery('input[name="contact_name"]').css('outline', '2px solid red');
			jQuery('input[name="contact_name"]').focus();
			err++;
            return false;
        }else{
            jQuery('input[name="contact_name"]').css('outline', 'none');
            jQuery('#error_name').remove();
        }
        var email = jQuery('input[name="contact_email"]').val();
        if(email == ''){
            jQuery('input[name="contact_email"]').css('outline', '2px solid red');
			jQuery('input[name="contact_email"]').focus();
			err++;
            return false;
        }else{
            jQuery('input[name="contact_email"]').css('outline', 'none');
            jQuery('#error_email').remove();
        }
        var captcha = jQuery('#tcaptcha_ans').val();
        var insert_captcha = jQuery('#contact_captcha_ans').val();
        if(insert_captcha == '') {
            jQuery('#contact_captcha_ans').css('outline', '2px solid red');
            jQuery('#contact_captcha_ans').closest('.input-field').after('<span class="error recaptcha-error">Please fill the captcha!</span>');
            jQuery('#contact_captcha_ans').focus();
            err++;
            return false;
        }
        if(insert_captcha != '' && insert_captcha!=captcha){
            jQuery('#contact_captcha_ans').css('outline', '2px solid red');
            jQuery('#contact_captcha_ans').closest('.input-field').after('<span class="error recaptcha-error">Captcha is invalid!</span>');
            jQuery('#contact_captcha_ans').focus();
            err++;
            return false;
        }else{
            jQuery('#contact_captcha_ans').css('outline', 'none');
        }
        if(err == 0){
            jQuery('#contactpage-submit-btn').html('Please Wait...');
            var data    = new FormData(jQuery("#cotact-page-contact-form")[0]);
            data.append('action', 'contact_form_submit');
            jQuery.ajax({
                url         :   itfirmsScriptData.ajaxUrl,
                type        :   'POST',
                data        :   data,
                contentType : 	false,
                processData	: 	false,
                success     : function(response){
                    const result = JSON.parse(response);
                    if(result.status){
                        jQuery('.error-msg').hide();
                        jQuery('.success-msg').html('');
                        jQuery('.success-msg').html(result.msg);
                        jQuery('.success-msg').show();
                        jQuery('#contactpage-submit-btn').html('Submit');
                        setTimeout(function() {
                            location.reload();                            
                        }, 2000);
                    }else{
                        jQuery('.success-msg').hide();
                        jQuery('.error-msg').html('');
                        jQuery('.error-msg').html(result.msg);
                        jQuery('.error-msg').show();
                        jQuery('#contactpage-submit-btn').html('Submit');
                    }
                },
                error: function(error){
                    console.log('AJAX Error:', error);
                    jQuery('#contactpage-submit-btn').html('Submit');
                }
            });
        }
    });

    jQuery(document).on('input', '#cotact-page-contact-form .contact-form-c-f', function(){
        savecontactinfo2();
    });

    var savecontactinfo2 = debounce(function(){
            var data    = new FormData(jQuery("#cotact-page-contact-form")[0]);
            data.append('action', 'contact_form_submit');
            jQuery.ajax({
                url         :   itfirmsScriptData.ajaxUrl,
                type        :   'POST',
                data        :   data,
                contentType : 	false,
                processData	: 	false,
                success     : function(response){
                    const result = JSON.parse(response);
                    // if(result.status){
                        
                    // }else{
                        
                    // }
                },
                error: function(error){
                    console.log('AJAX Error:', error);
                }
            });
    }, 1000);


    //Proposals fORM SUBMIT
    jQuery(document).on('click', '#proposals-form-submit-btn', function(e){
        e.preventDefault();
        var err = 0;
        jQuery('.error-msg, .error_message, .success-msg').remove();
        var name = jQuery('input[name="p_first_name"]').val();
        if(name == ''){
            jQuery('input[name="p_first_name"]').css('outline', '2px solid red');
			jQuery('input[name="p_first_name"]').focus();
			err++;
            return false;
        }else{
            jQuery('input[name="p_first_name"]').css('outline', 'none');
            jQuery('#error_name').remove();
        }
        var email = jQuery('input[name="p_email"]').val();
        if(email == ''){
            jQuery('input[name="p_email"]').css('outline', '2px solid red');
			jQuery('input[name="p_email"]').focus();
			err++;
            return false;
        }else{
            jQuery('input[name="p_email"]').css('outline', 'none');
            jQuery('#error_email').remove();
        }
        var captcha = jQuery('#p_tcaptcha_ans').val();
        var insert_captcha = jQuery('#p_captcha_ans').val();
        if(insert_captcha == ''){
            jQuery('#p_captcha_ans').css('outline', '2px solid red');
            jQuery('#p_captcha_ans').focus();
            jQuery('#p_captcha_ans').closest('.input-field').after('<span class="error error-msg">Please fill the Captcha!</span>');
            err++;
            return false;
        } else if(insert_captcha!=captcha) {
            jQuery('#p_captcha_ans').css('outline', '2px solid red');
            jQuery('#p_captcha_ans').focus();
            jQuery('#p_captcha_ans').closest('.input-field').after('<span class="error error-msg">Captcha is Invalid!</span>');
            err++;
            return false; 
        } else{
            jQuery('#p_captcha_ans').css('outline', 'none');
        }
        if(err == 0){
            jQuery('#proposals-form-submit-btn').html('Please Wait...');
            var data    = new FormData(jQuery("#proposals-form-id")[0]);            
            data.append('action', 'proposals_submit');
            jQuery.ajax({
                url         :   itfirmsScriptData.ajaxUrl,
                type        :   'POST',
                data        :   data,
                contentType : 	false,
                processData	: 	false,
                success     : function(response){
                    const result = JSON.parse(response);
                    console.log('Check', result);
                    if(result.status){
                        
                        jQuery('.error_message').hide();
                        jQuery('.success-msg').html('');
                        jQuery('.success-msg').html();
                        jQuery('#proposals-form-submit-btn').after('<div class="success-msg" style="color:green; display:none;">'+result.msg+'</div>');
                        jQuery('.success-msg').show();
                        jQuery('#proposals-form-submit-btn').html('Submit');
                        // setTimeout(() => {
                        //     location.reload();
                        // }, 2000);
                    }else{
                        jQuery('.success-msg').hide();
                        jQuery('.error_message').html('');
                        jQuery('#proposals-form-submit-btn').after('<div class="error_message" style="color:red; display:none;">'+result.msg+'</div>');
                        jQuery('.error_message').html(result.msg);
                        jQuery('.error_message').show();
                        jQuery('#proposals-form-submit-btn').html('Submit');
                    }
                },
                error: function(error){
                    console.log('AJAX Error:', error);
                    jQuery('#proposals-form-submit-btn').html('Submit');
                }
            });
        }
    });

    jQuery(document).on('input', '#proposals-form-id .proposals-form-c-f', function(){
        saveProposalsInfo();
    });

    var saveProposalsInfo = debounce(function(){
        var data    = new FormData(jQuery("#proposals-form-id")[0]);
            data.append('action', 'proposals_submit');
            jQuery.ajax({
                url         :   itfirmsScriptData.ajaxUrl,
                type        :   'POST',
                data        :   data,
                contentType : 	false,
                processData	: 	false,
                success     : function(response){
                    const result = JSON.parse(response);
                },
                error: function(error){
                    console.log('AJAX Error:', error);
                    jQuery('#proposals-form-submit-btn').html('Submit');
                }
            });
    }, 1000);

});