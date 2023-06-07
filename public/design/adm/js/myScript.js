/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


(function($) {
	"use strict";
    //var $form = $("#register-form");
    if($("form[data-form-validate='true']").length>0){
        $("form[data-form-validate='true']").each(function() {
            $(this).validate({
                errorPlacement: function(error, element) {
                    // to append radio group validation erro after radio group            
                    if (element.is(":radio")) {
                        error.appendTo(element.parents('.form-group'));
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
        });
    } 
 
	$(document).on("click",".page_attribute", function(event){
		var this2=$(this);
		var enableDiv=$(this).val();
		$(document).find('.page_attribute_value').css('display','none');
		$(document).find('.'+enableDiv).css('display','block');
	}); 

	$(".ajax-form").on("submit", function(event){
		if($(".ajax-form").valid()){
			var this2=$(this);
            var csrfName = $('#cff').attr('name'); // CSRF Token name
            var csrfHash = $('#cff').val(); // CSRF hash
			var formData = new FormData(this);
			//debugger;
			event.preventDefault();
			$(this).find(".ajax-message").html('<i class="fa fa-spinner fa-spin" style="float: right;padding: 10px;margin-right: 50px;color: #000;font-size: 40px;"></i>');
			$(this).find(".ajax-submit-btn").attr("disabled", "disabled");
			$.ajax({
				url:this.action,
				type:"POST",
				data:formData,
				cache:false,
				contentType: false,
				processData: false,
				dataType:"json",
				beforeSend:function(){
					$(this).find(".ajax-submit-btn").attr("disabled", "disabled");
				},
				success:function(data){
					
					if(data.success){
						$('.ajax-form').each(function(){
							this.reset();
						});
						$(this2).find(".ajax-message").html(data.success);
					}
					if(data.errors){
						$(this2).find(".ajax-message").html(data.errors);
					}
					$(this2).find(".ajax-submit-btn").attr("disabled", false);
					
					if(data.redirect){
						window.location.replace(data.redirect);
					}
					if(data.newmessage){
						$(this2).find("#newmessage").prepend(data.newmessage);
						$(this2).find(".ajax-message").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Success:</strong> updated...<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
					}
					$(document).find("input[name="+data.cff+"]").val(data.cfv);
					$(document).find("#cff").val(data.cfv);
				}
			});
		}
	});
	$(document).on("change",".autoupload", function(event){
		var this2=$(this);
		if($(this).closest('.mainatl').length>0){
			var td=$(this).closest('.mainatl');
		}else{
			var td=$(this).closest('td');
		}
		var csrfName = $('#cff').attr('name'); // CSRF Token name
        var csrfHash = $('#cff').val(); // CSRF hash
		
		var form=$(this).closest('form');
		var token=$(form).find('input[name=nitd_form]').val();
		var cslug=$(form).find('input[name=cslug]').val();
		var baseurl = $('#baseurl').val();
		var file_data = this2.prop('files')[0];   
		var formData = new FormData();
		formData.append('fileup', file_data);
		formData.append('filename', this2.attr("name"));
		formData.append('extension', this2.data("extension"));
		formData.append('maxsize', this2.data("maxsize"));
		formData.append('cslug', cslug);
		formData.append(''+csrfName+'', csrfHash);
		
		//debugger;
		event.preventDefault();
		$(td).find(".filemsg").html('<i class="fa fa-spinner fa-spin" style="float: right;padding: 10px;margin-right: 50px;color: #000;font-size: 40px;"></i>');
		$(form).find(".ajax-submit-btn").attr("disabled", "disabled");
		$.ajax({
			url:baseurl+'api/autoupload',
			type:"POST",
			data:formData,
			cache:false,
			contentType: false,
			processData: false,
			dataType:"json",
			success:function(data){                	
				if(data.success){
					this2.val(null);
					if($(td).find('a').length>0){
						$(td).find('a').attr("href", baseurl+data.filename);
						$(td).find(".filemsg").html(data.success);
					}else{
						$(td).find(".filemsg").html('<a href="'+baseurl+data.filename+'" target="_blank">'+data.success+'</a>');
					}
					if($(td).find('input[name="old_'+this2.attr("name")+'"]').length>0){
						$(td).find('input[name="old_'+this2.attr("name")+'"]').val(data.filename);
					}else{
						$(td).find('input#'+this2.attr("name")).val(data.filename);
					}
				}
				if(data.errors){
					$(td).find(".filemsg").html(data.errors);
				}
				$(form).find(".ajax-submit-btn").attr("disabled", false);

				$(document).find("input[name="+data.cff+"]").val(data.cfv);
				$(document).find("#cfv").val(data.cfv);
			}
		});
	}); 
	
	
})(jQuery);
 