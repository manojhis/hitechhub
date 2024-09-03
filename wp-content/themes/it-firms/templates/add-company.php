<?php 
/* Template Name: Add Company */

get_header();
$current_url = add_query_arg(array(), home_url($wp->request));
?>
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/css/add-company.min.css">
<link rel="stylesheet" href="<?php echo IT_HIPL_THEME_DIR;?>/assets/libs/select2/select2.min.css">
<section class="section-spacing">
	<div class="container">
		<div class="row" id="company-registration">
			<div class="col-xl-10 col-sm-12 col-12 mx-auto">
				<div class="section-heading text-center d-block">
					<h1 class="title">Showcase Your Business Today!</h1>
					<p>Get Free Proposals from Top Agencies</p>
				</div>
			</div>
			<div class="col-sm-12 col-12">
				<div class="contactus-card">
					<form enctype="multipart/form-data" id="company_register" method="POST" name="company_register" class="add-company-page-form form" novalidate="novalidate">
						<input type="hidden" name="action" value="Insert_Company_Records">
						<div class="input-box">
							<div class="form-group">
								<label>Company Title</label>
								<input type="text" class="form-control" id="company_title" name="company_title" placeholder="Company Name*" required="required">
							</div>	
							<div class="form-group">
								<label>Website Url</label>
								<input type="text" class="form-control" id="company_website" name="company_website" placeholder="https://www.website.xyz">
							</div>
							<div class="form-group">
								<label>Country Name (Max.3)</label>
								<input type="text" class="form-control valid" id="company_location" name="company_location" placeholder="USA, Ukraine, Australia" aria-invalid="false">
							</div>
							<div class="form-group">
								<label>Company Established On</label>
								<select name="company_established_date" class="form-control required selected-opetion" id="company_established_date">
									<option value="">Select Established year</option>
									<option value="1980">1980</option>
									<option value="1981">1981</option>
									<option value="1982">1982</option>
									<option value="1983">1983</option>
									<option value="1984">1984</option>
									<option value="1985">1985</option>
									<option value="1986">1986</option>
									<option value="1987">1987</option>
									<option value="1988">1988</option>
									<option value="1989">1989</option>
									<option value="1990">1990</option>
									<option value="1991">1991</option>
									<option value="1992">1992</option>
									<option value="1993">1993</option>
									<option value="1994">1994</option>
									<option value="1995">1995</option>
									<option value="1996">1996</option>
									<option value="1997">1997</option>
									<option value="1998">1998</option>
									<option value="1999">1999</option>
									<option value="2000">2000</option>
									<option value="2001">2001</option>
									<option value="2002">2002</option>
									<option value="2003">2003</option>
									<option value="2004">2004</option>
									<option value="2005">2005</option>
									<option value="2006">2006</option>
									<option value="2007">2007</option>
									<option value="2008">2008</option>
									<option value="2009">2009</option>
									<option value="2010">2010</option>
									<option value="2011">2011</option>
									<option value="2012">2012</option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024">2024</option>
								</select>
							</div>
							<div class="form-group">
								<label>Employees</label>
								<select name="company_employees" class="form-control required selected-opetion" id="company_employees">
									<option value="">Select Employees </option>
									<option value="0-10">0-10</option>
									<option value="11-50">11-50</option>
									<option value="51-100">51 - 100</option>
									<option value="101-250">101 - 250</option>
									<option value="251-500">251 - 500</option>
									<option value="501-1000">501-1000</option>
									<option value="1000+">1000+</option>
								</select>
							</div>
							<div class="form-group">
								<label>Avg. Hourly Rate</label>
								<select name="company_price" class="form-control required selected-opetion" id="company_price">
									<option value="">Select Avg. Hourly Rate</option>
									<option value="$25/hr.">$25/hr.</option>
									<option value="$25-$49/hr.">$25 - $49/hr.</option>
									<option value="$50-$99/hr.">$50 - $99/hr.</option>
									<option value="$100-149/hr.">$100 - $149/hr.</option>
									<option value="$150-199/hr.">$150 - $199/hr.</option>
									<option value="$200/hr.+">$200/hr.+</option>
								</select>
							</div>			
							<div class="form-group">
								<label>Company Email</label>
								<input type="text" class="form-control" id="email" name="email" placeholder="email@website.xyz">
							</div>		
							<div class="form-group">
								<label>Company Contact</label>
								<input type="text" class="form-control numberOnly" id="company_contact" name="company_contact"  placeholder="+1-111-111-1111">
							</div>
							<div class="form-group">
								<label>Upload Logo</label>
								<div class="file-upload-form uploader">
									<label for="img_logo" class="choose-file">
										<span class="file-name">Choose File</span>
										<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/icon/upload.svg" alt="upload">
									</label>
									<input class="file-upload required valid" type="file" id="img_logo" name="img_logo" accept="image/*" aria-invalid="false">
								</div>	
							</div>	
							<div class="form-group half-row mT20">
								<label>Services Provided</label>
								<textarea name="company_services" id="company_services" maxlength="300" class="form-control" rows="3"></textarea>
							</div>
							<div class="form-group half-row">
								<label>Key Client</label>
								<textarea name="company_key_client" id="company_key_client" maxlength="150" class="form-control" rows="3"></textarea>
							</div>
							<div class="form-group full-row">
								<label>Description</label>
								<textarea name="company_description" id="company_description" class="form-control required" maxlength="700" rows="3"></textarea>
							</div>
							<div class="form-group enter-value">
	                            <div class="input-field">
	                                <span class="company_question" id="company_question"></span>
	                                <input type="hidden" name="company_tcaptcha_ans" id="company_tcaptcha_ans" value="">
	                                <input type="hidden" name="contact_current_page" name="contact_current_page" value="<?php echo $current_url; ?>">
	                                <input type="text" name="" placeholder="Value*" class="form-control" id="company_captcha_ans">
	                            </div>
	                        </div>
						</div>
						<div class="full-row">
							<!-- <div class="success-msg">Company Information submitted!</div> -->
							<button type="submit" id="company-submit-form" class="darkbtn meduim blue-btn submit-form btn btn-theme1">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
?>
<script src="<?php echo IT_HIPL_THEME_DIR;?>/assets/libs/jquery-3.3.1.min.js"></script>
<script src="<?php echo IT_HIPL_THEME_DIR;?>/assets/libs/select2/select2.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(e){
	jQuery(document).on('click', '#company-submit-form', function(e){
		e.preventDefault();	
		var err = 0;
		$('.success-msg, .error_message').remove();
		var company_title = jQuery('#company_title').val();
		var cap_value = jQuery('#company_tcaptcha_ans').val();
		var company_captcha_ans = jQuery('#company_captcha_ans').val();
		if(company_title == ''){
			jQuery('#company_title').css('outline', '2px solid red');
			jQuery('#error_company_title').remove();
			jQuery('#company_title').after('<span class="error" id="error_company_title" style="color:red; display:block;">Please fill out this field.</span>');
			jQuery('#company_title').focus();
			err++;
            return false;
		}else{
			jQuery('#company_title').css('outline', 'none');
			jQuery('#error_company_title').remove();
		}

		const companyLocationValue = $('#company_location').val();
        const company_values = companyLocationValue.split(',').map(v => v.trim()).filter(v => v !== '');
		if(companyLocationValue != '' && company_values.length > 3) {
			jQuery('#company_captcha_ans').css('outline', '2px solid red');
			jQuery('#company_location').after('<span class="error" id="error_company_title" style="color:red; display:block;">You cannont choose more than three countries.</span>');
			jQuery('#company_captcha_ans').focus();
			err++;
            return false;
		}
		if(company_captcha_ans == ''){
			jQuery('#company_captcha_ans').css('outline', '2px solid red');
			jQuery('.input-field').after('<span class="error" id="error_company_title" style="color:red; display:block;">Please fill out this field.</span>');
			jQuery('#company_captcha_ans').focus();
			err++;
            return false;
		} else if(company_captcha_ans && company_captcha_ans!= cap_value){
			jQuery('#company_captcha_ans').css('outline', '2px solid red');
			jQuery('.error').remove();
			jQuery('.input-field').after('<span class="error" id="error_company_title" style="color:red; display:block;">Captcha is Invalid!</span>');
			jQuery('#company_captcha_ans').focus();
			err++;
            return false;
		} else{
			jQuery('#company_captcha_ans').css('outline', 'none');
			jQuery('.error').remove();
		}

		if(err == 0){
			var r = new FormData(jQuery("#company_register")[0]);
			jQuery.ajax({
				url				: 	'<?php echo admin_url('admin-ajax.php');?>',
				type			: 	'POST',
				data			: 	r,
				contentType		: 	!1,
				processData		: 	!1,
				beforeSend		: 	function(){},
				success			: 	function(a){					
				const res = JSON.parse(a);
				console.log(res);
				if (res.status && res.status === 'success') {					
					jQuery('#company-submit-form').after('<div class="success-msg">'+res.message+'</div>');
					setTimeout(function(){ 
						location.reload();
					 }, 2000);
				} else {
					jQuery('#company-submit-form').after('<span class="error_message error">' + res.message + '</span>');
				}
				},
				error			: function(a){
					console.log(a);
				}
			});
		}
    });

	// User shouldn't be able to type Numeric
	$(document).ready(function() {
		$('#company_location').on('input', function() {
			// Allow only alphabets, comma, apostrophe, and space
			this.value = this.value.replace(/[^a-zA-Z,'\s]/g, '');

			// Prevent consecutive commas, apostrophes, or spaces
			this.value = this.value.replace(/([,'\s])\1+/g, '$1');
		});
	});
	const $fileInput = $('#img_logo');
  	const $fileNameDisplay = $('.choose-file .file-name');

	$fileInput.on('change', function() {
		if (this.files.length > 0) {
		$fileNameDisplay.text(this.files[0].name);
		} else {
		$fileNameDisplay.text('Choose File');
		}
	});

});
jQuery(document).ready(function() {
	jQuery('.selected-opetion').select2();
});
var total;
function getRandom() {
    return Math.ceil(20 * Math.random());
}
function createSum() {
    var e = getRandom(),
        a = getRandom();
    (total = e + a),
        jQuery("#company_question").text(e + " + " + a + " = "),
        jQuery("#company_tcaptcha_ans").val(total);
}
jQuery(document).ready(function () {
    createSum()
});
</script>