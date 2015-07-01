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
			<p><strong>Email: {{ $email }}</strong></p>
			<p><strong>Subscription Plan: {{ $plan }}</strong></p>
			<br><br>
			<h5>Regards</h5>
			<p>System Admin</p>
			<p><strong>Easychecklist ABC</strong></p>
			<p>
				<a href="http:://www.easychecklistabc.com">
					<em>www.easychecklistabc.com</em>
				</a>
			</p>
		</div>
	</body>
</html>