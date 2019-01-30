<!DOCTYPE html>
<html>
<head>
	<!-- <title>How to send mail using queue in Laravel 5.7? - ItSolutionStuff.com</title> -->
</head>
<body>
 Hello,<br>
 <h2>Welcome to the site {{env('APP_NAME')}}</h2>
<h3>
	Please click on 'Verify' button to complete the registration process <br>
	<a target="_blank" href="{{ $data['url'] }}">Verify Email Address</a>
</h3>

<hr>
<p>If you're having trouble clicking the 'Verify Email Address' button, copy and paste the URL below into your web browser<br>
{{ $data['url'] }}
</p>

</body>

</html>