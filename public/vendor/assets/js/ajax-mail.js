$(function() {

	// Get the form.
	var form = $('#contact-form');

	// Get the messages div.
	var formMessages = $('.form-messege');

	// Set up an event listener for the contact form.
	$(form).submit(function(e) {
		// Stop the browser from submitting the form.
		e.preventDefault();

		// Serialize the form data.
		var formData = $(form).serialize();

		// Submit the form using AJAX.
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: $(form).attr('action'),
			data: formData,
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
		})
		.done(function(response) {
		    var removeClass = 'error';
		    var addClass = 'success';
		    if (response.status == 400) {
		        removeClass = 'success';
		        addClass = 'error';
		    } else {
		        $('#contact-form input,#contact-form textarea').val('');
		    }
			// Make sure that the formMessages div has the 'success' class.
			$(formMessages).removeClass(removeClass);
			$(formMessages).addClass(addClass);
			// Set the message text.
			$(formMessages).text(response.msg);
		})
		.fail(function(data) {
			// Make sure that the formMessages div has the 'error' class.
			$(formMessages).removeClass('success');
			$(formMessages).addClass('error');
            
			// Set the message text.
			if (data.responseText !== '') {
				$(formMessages).text(data.responseText);
			} else {
				$(formMessages).text('Oops! An error occured and your message could not be sent.');
			}
		});
	});

});
