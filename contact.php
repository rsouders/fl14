<?php require 'includes/config.php';?>
<?php $title = "Contact"; ?>
<?php include 'includes/header.php';?>
<style>
input[type="text"], input[type="email"]   {
	width:300px;
	height:20px;
	margin-bottom:8px;
}
input[type="submit"]  {
	width:100px;
	border-radius:5px;
	background:orange;
}

input[type="radio"], input[type="checkbox"]  {
	margin:0 8px 5px 8px;
}

textarea  {
	width:500px;
	margin-bottom:10px;
}
</style>
<h1>Contact Us</h1>
<p>
Please use this form for general questions or comments. If you would like more information to help you plan your next tropical vacation, visit our <a href="request.php">Request Info</a> page.
</p>
<?php
if(isset($_POST['first_name'])) //parameter must be one of the "name" fields used below; will display in resulting email
{//if there's data, show it
	//echo $_POST['FirstName'];
	
	$message = process_post();
	safeEmail('rsoude01@seattlecentral.edu','Test Subject',$message);
	
	echo 'Thank you for your message!';
	
}else{//if there's no data, show the form
	echo '
	<form action="contact.php" method="post">
	First Name: <input type="text" name="first_name" required="required" />
	<br />
	<br />
	Email: <input type="email" name="email" required="required" placeholder="Please enter a valid email address"/>
	<br />
	<br />
	Comments:
	<br />
	<br />
	<textarea name="comments"></textarea>
	<br />
	<br />
	<input type="submit" value="Click me!" />
	</form>
	';
}

?>
<?php include 'includes/footer.php';?>