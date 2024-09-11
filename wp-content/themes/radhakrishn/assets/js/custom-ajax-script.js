var ids = {};
var filter_clear = [];
var page = 1;

(function($) {
    "use strict";
    $(document).ready(function() {

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

                var username = $('#username').val();
                var password = $('#password').val();
                var security = $('#security').val();

                var data = {
                    'action': 'ajaxlogin',
                    'username': username,
                    'password': password,
                    'security': security
                };

                jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajax_object.ajax_url,
                    data: $("#loginForm").serialize(),
                    success: function(response) {
                        // Handle successful login response (e.g., redirect to desired page)
                        console.log(response);
                            if( response.success == true ){
                                $(".form-message").html("<p class='alert alert-success'>" + response.message + "</p>");
                                window.location.href = response.data.redirect_to;
                                return;
                            } else{
                                $(".form-message").html("<p class='alert alert-danger'>" + response.message + "</p>");
                            }
                            return false;
                      },
                      error: function(jqXHR, textStatus, errorThrown) {
                        console.error(textStatus, errorThrown);
                      }
                });
 
            });


       


        $('#registerform').on('submit', function(e) {
            e.preventDefault();
       
            //alert("hello");
           

            var data = {
                action: 'user_register',
                ajax_data: $(this).serialize()
            };

            $.post(ajax_object.ajax_url, data, function(response) {
                console.log(response);
                if (response.status) {
                    $('#registerform').hide();
                    $('#registerMessage').html('<p>' + response.message + '</p><p>Didn\'t receive an email or expired? <a href="#" id="resendVerification">Resend Verification Email</a></p>').show();
                } else {
                    $('#registerMessage').html('<p>' + response.message + '</p>').show();
                }
            });
             
       });


        

        


    });
    })(this.jQuery);