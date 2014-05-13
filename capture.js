/**
 * I'm using Zepto to simplify code examples
 */

Zepto(function($){

	// Detect when the email field has changed (when an email has been added.)
	$('form.sign-up input[name=email]').on('change', function(event) {

		// Ensure it is a valid email (maybe not the most comprehensive regex, but it will work for this example)
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (filter.test(event.target.value)) {

			$.post('./add-target.php', { email: event.target.value }, function(response){
				// We don't really care what the response is.
			})

		}

	});

});
