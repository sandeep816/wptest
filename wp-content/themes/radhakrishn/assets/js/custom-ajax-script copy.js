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


        // das
        // $("#loginForm").validate({
        //     submitHandler: function (form) {
        //         jQuery.ajax({
        //             type: 'POST',
        //             dataType: 'json',
        //             url: ajax_object.ajax_url,
        //             data: $("#loginForm").serialize(),
        //             success: function(response) {
        //                 // Handle successful login response (e.g., redirect to desired page)
        //                 console.log(response);
        //                     if( response.success == true ){
        //                         $(".form-message").html("<p class='alert alert-success'>" + response.data.message + "</p>");
        //                         //$("#loginForm")[0].reset();
        //                         window.location.href = response.data.redirect_to;
        //                         return;
        //                     } else{
        //                         $(".form-message").html("<p class='alert alert-danger'>" + response.data + "</p>");
        //                     }
        //                     return false;
        //               },
        //               error: function(jqXHR, textStatus, errorThrown) {
        //                 console.error(textStatus, errorThrown);
        //               }
        //         });

        //     }
        // });


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
                    //alert(response.message);
                    $('#registerMessage').html('<p>' + response.message + '</p>').show();
                }
            });
             
       });


        // $("#registerform").validate({
        //     rules: {
        //         fname: "required",
        //         lname: "required",
        //         register_email: {
		// 			required: true,
		// 			email: true
		// 		},
		// 		// register_username: {
		// 		// 	required: true,
		// 		// 	minlength: 2
		// 		// },
		// 		register_password: {
		// 			required: true,
		// 			minlength: 5
		// 		},
		// 		confirm_password: {
		// 			required: true,
		// 			minlength: 5,
		// 			equalTo: "#register_password"
		// 		},
        //         agree: "required"
        //     },
        //     messages: {
        //         fname: "Please enter your firstname",
        //         lastname: "Please enter your lastname",
        //         email: "Please enter a valid email address",
		// 		// register_username: {
		// 		// 	required: "Please enter a username",
		// 		// 	minlength: "Your username must consist of at least 2 characters"
		// 		// },
		// 		password: {
		// 			required: "Please provide a password",
		// 			minlength: "Your password must be at least 5 characters long"
		// 		},
		// 		confirm_password: {
		// 			required: "Please provide a password",
		// 			minlength: "Your password must be at least 5 characters long",
		// 			equalTo: "Please enter the same password as above"
		// 		},
        //         agree: "Please accept our policy",
        //     },
        //     submitHandler: function(form) {
        //         $(form).find('.button').val($(form).find('.button').data('process'));
        //         $.ajax({
        //             type: "POST",
        //             url: ajax_object.ajax_url,
        //             dataType: "json",
        //             data: {'action': 'user_register', 'ajax_data' : $(form).serialize()},
        //             beforeSend: function(){},
        //             success: function (response) {
        //                 console.log(response);
        //                 if( response.status == true ){
        //                     $(".form-message").html("<p class='alert alert-success'>" + response.data.message + "</p>");
        //                 }  else { 
        //                     $(".form-message").html("<p class='alert alert-success'>" + response.data.message + "</p>");
        //                 }
        //                 $(form).find('.button').val($(form).find('.button').data('string'));
        //                 return false;
        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {
        //                 console.error(textStatus, errorThrown);
        //               }
        //         });

        //     }
        // });


        //
        $('#edit-profile-form').on('submit', function(e) {
            e.preventDefault();
    
            var formData = new FormData(this);
    
            $.ajax({
                type: 'POST',
                url: ajax_object.ajax_url,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('.response-message').html(response);
                }
            });
        });

        //

     

        function load_movies(genre, language, year, page){
            // Show the skeleton loader
            $('#skeleton-loader').show();
            $('.movie-list').hide();


            $.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                dataType: "json",
                data: {
                    action: 'get_post_data',
                    genre: genre,
                    language: language,
                    year: year,
                    page: page,
                    nonce: ajax_object.ajax_nonce
                },
                success: function(response){
                    //console.log(response);
                    if(response.success)
                    {
                        $('.movie-list').html(response.data);
                        $(".showing-number").html(response.text);
                        }
                  else{
                    $('.movie-list').html(response.data);
                    $(".showing-number").html('');
                  }

                  // Hide the skeleton loader
                  $('#skeleton-loader').hide();
                  $('.movie-list').show();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + status + error);

                    // Hide the skeleton loader
                    $('#skeleton-loader').hide();
                    $('.movie-list').show();
                }
            });
        }


        $('#movie-filter').on('submit', function(e){
            e.preventDefault();
            var genre = $('#genre').val();
            var language = $('#language').val();
            var year = $('#year').val();
            load_movies(genre, language, year, 1);
        });

        $(document).on('click', '.pagination a', function(e)
        {
            e.preventDefault();
            var page = parseInt($(this).attr('href').replace(/\D/g, ''));
            var genre = $('#genre').val();
            var language = $('#language').val();
            var year = $('#year').val();
            load_movies(genre, language, year, page);
        })




        //

        // $('#movie-filter').on('submit', function(e){
        //     e.preventDefault();
        //     var genre = $('#genre').val();
        //     var year = $('#year').val();
        //     var page = $(this).data('page');
        //     //var page = $('#page').val();
        //     $.ajax({
        //         url: ajax_object.ajax_url,
        //         type: 'post',
        //         dataType: "json",
        //         data: {
        //             action: 'get_post_data',
        //             genre: genre,
        //             year: year,
        //             page:page,
        //             nonce: ajax_object.ajax_nonce
        //         },
        //         success: function(response){
        //             //console.log(response);
        //             if(response.success)
        //             {
        //                 $('.movie-list').html(response.data);
        //                 $(".showing-number").html(response.text);
        //                 }
        //           else{
        //             $('.movie-list').html(response.data);
        //             $(".showing-number").html('');
        //           }
        //         }
        //     });
        // });


        //   //function for pagination

        //   $(document).on('click', '.pagination a', function(e)
        // {
        //     e.preventDefault();
        //     page = parseInt(jQuery(this).attr('href').replace(/\D/g,''));
        //     //alert($(this));
        // })
    


    });
    })(this.jQuery);