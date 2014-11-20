<?php require 'includes/config.php';?>
<?php $title = "Request Info"; ?>
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
<h1>What information can we send you?</h1>
<p>
We have reams of brochures about different types of vacations you can take in these tropical locales. Let us know what we can send you for free, in PDF format.
</p>
<?php
if(isset($_POST['first_name'])) //parameter must be one of the "name" fields used below; will display in resulting email
{//if there's data, show it
	//echo $_POST['FirstName'];
	
	$message = process_post();
	safeEmail('rsoude01@seattlecentral.edu','Send me info!',$message);
	
	echo 'Thank you for your request!';
	
}else{//if there's no data, show the form
	echo '
	<form action="request.php" method="post">
	<b>First Name:</b> <input type="text" name="first_name" required="required" />
	<br />
	<br />
	<b>Email:</b> <input type="email" name="email" required="required" placeholder="Please enter a valid email address"/>
	<br />
	<br />
	<b>What type of vacation are you looking for?</b>
	<br />
	<br />
	<p><input type="radio" name="vacation_type" value="spoil" >Spoil me!</p>
	<p><input type="radio" name="vacation_type" value="active" >Keep me active!</p>
	<p><input type="radio" name="vacation_type" value="eco" >Help me explore natural beauty!</p>
	<br />
	<b>What locations would you like to consider?</b>
	<br />
	<br />
	<p><input type="checkbox" name="location[]" value="hawaii" id="location1" >Hawaii</p>
	<p><input type="checkbox" name="location[]" value="jamaica" id="location2" >Jamaica</p>
	<p><input type="checkbox" name="location[]" value="fiji" id="location3" >Fiji</p>
	<br />

	<b>Please describe any special needs you may have, such as ADA accommodations:</b><textarea name="needs"></textarea>
	<br />
	<br />
	<input type="submit" value="Click me!" />
	</form>
	';
}

?>
<?php include 'includes/footer.php';?>