<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ $mail_title }}</h2>

		<div>
			<p><strong>Dear User,</strong></p>
			<p>Reminder for the Checklist / Task you were assigned to.</p>
			<p><strong>{{ $notify_about }}</strong></p>
			<p style="color: #FC0000;"><strong>Due Date: {{ $due_date }}</strong></p>
			<br><br>
			<h5>Regards</h5>
			<p>Super Admin</p>
		</div>
	</body>
</html>