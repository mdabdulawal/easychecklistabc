<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ $mail_title }}</h2>

		<div>
			<p><strong>Dear User,</strong></p>
			<p>{{ $intro_msg }}</p>
			<p><strong>Email: {{ $temp_email }}</strong></p>
			<p><strong>Password: {{ $temp_password }}</strong></p>
			<br><br>
			<h5>Regards</h5>
			<p>Super Admin</p>
		</div>
	</body>
</html>