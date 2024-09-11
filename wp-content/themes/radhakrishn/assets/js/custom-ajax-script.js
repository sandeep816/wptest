(function($) {
    "use strict";
    $(document).ready(function() {
        // Login Form
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
    
            var data = {
                action: 'user_login',
                ajax_data: $(this).serialize()
            };
    
            $.post(ajax_object.ajax_url, data, function(response) {
                if (response.status) {
                    $('#loginForm').hide();
                    $('#loginMessage').html('<p>' + response.message + '</p>').show();
                    if (response.redirect_to) {
                        window.location.href = response.redirect_to;
                    }
                } else {
                    $('#loginMessage').html('<p>' + response.message + '</p>').show();
                }
            });
        });

    // Register Form        
     $('#registerform').on('submit', function(e) {
            e.preventDefault();
       
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

    // Resend Verification Email
    $(document).on('click', '#resendVerification', function(e) {
        e.preventDefault();

        var userId = $(this).data('user-id'); // Assuming you have the user ID stored in a data attribute

        var data = {
            action: 'resend_verification_email',
            user_id: userId
        };

        $.post(ajax_object.ajax_url, data, function(response) {
            if (response.status) {
                $('#registerMessage').html('<p>' + response.message + '</p>');
            } else {
                $('#registerMessage').html('<p>' + response.message + '</p>');
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        });
    });

    // Forgot Password Form

    $('#forgotPasswordForm').on('submit', function(e) {
        e.preventDefault();

        var data = {
            action: 'forgot_password',
            user_email: $('input[name="user_email"]').val()
        };

        $.post(ajax_object.ajax_url, data, function(response) {
            $('#forgotPasswordMessage').html('<p>' + response.message + '</p>').show();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        });
    });

    // Reset Password Form
    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();

        var data = {
            action: 'reset_password',
            reset_key: $('input[name="reset_key"]').val(),
            user_login: $('input[name="user_login"]').val(),
            new_password: $('input[name="new_password"]').val()
        };

        $.post(ajax_object.ajax_url, data, function(response) {
            $('#resetPasswordMessage').html('<p>' + response.message + '</p>').show();
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
        });
    });


    });
    })(this.jQuery);