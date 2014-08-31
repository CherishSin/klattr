<?php

$outfile = "/tmp/output.txt";

include "/data/klattr.com/www/includes/auth";

if ($auth == 1) {
	$target = $_POST['sub_to'];

	$sql = "SELECT Subscribed_To FROM Users WHERE ID='$UID'";
	$sql_results = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($sql_results);
	$sub_list = $row['Subscribed_To'];

	if (preg_match("/^[a-zA-Z0-9_]+$/",$target)) {

		$target_matcher = " " . $target . " ";

		if (strpos($sub_list, $target_matcher) !== false) {
			$sub_list = str_replace($target_matcher, " ", $sub_list);
		} else {
			$sub_list = $sub_list . $target_matcher;
			$sub_list = str_replace('  ',' ',$sub_list);
		}

		$sql = "UPDATE Users SET Subscribed_To='$sub_list' WHERE ID='$UID'";
		mysqli_query($con,$sql);
	}

	//
	// Add the current user to the list of Subscribers for the person they're subscribing to
	$sql = "SELECT Subscribers FROM Users WHERE Handle='$target'";
	$sql_results = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($sql_results);
	$sub_list = $row['Subscribers'];

	if (preg_match("/^[a-zA-Z0-9_]+$/",$UID)) {

		$target_matcher = " " . $UID. " ";

		if (strpos($sub_list, $target_matcher) !== false) {
			$sub_list = str_replace($target_matcher, " ", $sub_list);
		} else {
			$sub_list = $sub_list . $target_matcher;
			$sub_list = str_replace('  ',' ',$sub_list);
            $adding = 1;
		}

		$sql = "UPDATE Users SET Subscribers='$sub_list' WHERE Handle='$target'";
		mysqli_query($con,$sql);
	}

    // send emails to the subscribee
    $sql = "SELECT Name, Email_Addr FROM Users WHERE Handle = '$target' AND Activated = '1'";
    $sql_result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($sql_result);
    if ($row['Name'] != "" && $adding == 1) {
      $emailText = file_get_contents("/data/klattr.com/www/includes/new_subscriber_email_template");
      $emailText = str_replace("FULLNAME", $row['Name'], $emailText);
      $emailText = str_replace("SENDER", $uname, $emailText);
      $headers = "From: Klattr Team <administrator@klattr.com>\r\nReply-To: No Reply\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      mail($row['Email_Addr'], "You have a new subscriber!", $emailText, $headers);
    }
    	

} else {
	header( 'Location: https://klattr.com' );
}
?>
