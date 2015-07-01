<?php
$con=mysqli_connect("localhost","root","","brokenbu_ezabc");
//$con=mysqli_connect("localhost","brokenbu_nahidul","X3mdF,e&T?(z","brokenbu_ezabc");

// Check connection
if (mysqli_connect_errno()) {
  //echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

else
$todste = date("Y-m-d");
//echo $todste.'<br/>';
$sql = "SELECT * FROM `checklist_reminders`
		LEFT JOIN users on users.id = checklist_reminders.user_id
		LEFT JOIN checklists on checklists.id = checklist_reminders.checklist_id
		WHERE notify_date =  '$todste'
		LIMIT 10";


$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {

 //$api_key="key-a758d93749be908429b0ed9281760a8a";/* Api Key got from https://mailgun.com/cp/my_account */
curl_exec(curl -s --user 'api:key-a758d93749be908429b0ed9281760a8a' 
    https://api.mailgun.net/v2/samples.mailgun.org/messages 
    -F from='Excited User <me@samples.mailgun.org>' 
    -F to=awalcse05@gmail.com 
    -F to=awalcse05@gmail.com 
    -F subject='Hello' 
    -F text='Testing some Mailgun awesomness!');		      

  echo $row['notify_date'] . " " . $row['user_id']. " " . $row['email']. " " . $row['title'];
  echo "<br>";
}

mysqli_close($con);
?>



