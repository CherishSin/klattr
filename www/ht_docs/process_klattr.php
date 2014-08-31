<?php
include "/data/klattr.com/www/includes/auth";

if ($auth == 1) {

  $parent = 0;
  $private = 0;
  $ttl = 0;

  $klattr_path = $_FILES['klattr_audio']['tmp_name'];

  $title = $_POST['klattr_title'];
  $recipients = $_POST['klattr_recipients'];
  $tags = $_POST['klattr_tags'];
  if (isset($_POST['parent_id'])) {
    $parent = $_POST['parent_id'];
  }

  $title = substr($title, 0, 20);
  $title = htmlspecialchars($title);
  $title = addslashes($title);

  $recipients = htmlspecialchars($recipients);
  $recipients = str_replace(";", " ", $recipients);
  $recipients = str_replace(",", " ", $recipients);
  $recipients = str_replace("  ", " ", $recipients);
  $recipient_regex = str_replace(" ", "|", $recipients);
  $recipients = " " . $recipients . " ";
  $recipients = addslashes($recipients);

  $recipient_array = explode(" ", $recipients);


  $tags = htmlspecialchars($tags);
  $tags = str_replace(";", " ", $tags);
  $tags = str_replace(",", " ", $tags);
  $tags = $tags . " ";
  $tags = addslashes($tags);

  $randomData = file_get_contents('/dev/urandom', false, null, 0, 64) . uniqid(mt_rand(), true);
  $randkey = substr(str_replace(array('/','=','+'),'', base64_encode($randomData)),0,64);
  $dateString = date("Ymdhis");
  $postDate = date("Y-m-d H:i:s");
  $nameString = str_replace(' ','',$uname);
  $uniqueName = $nameString . $randkey . $dateString;
  $wav2png = "/etc/wav2png/wav2png";
  $oggenc = "/usr/bin/oggenc";
  $lame = "/usr/bin/lame";
  $imagePath = "/tmp/" . $uniqueName . ".png";

  $wav2pngResult = `$wav2png --foreground-color=FFFFFFFF --background-color=686A88FF -w 700 -h 100 -d -o $imagePath $klattr_path  2>&1`;
  $oggencResults = `$oggenc -o /data/klattr.com/www/povs/$uniqueName.ogg $klattr_path`;
  $lameResults = `$lame $klattr_path /data/klattr.com/www/povs/$uniqueName.mp3`;

  $waveform = new Imagick($imagePath);
  $waveform->setImageFormat('png');
  $waveform = addslashes($waveform);

  //$sql = "INSERT INTO Povs (Title, Tags, Data, Poster, Recipient, Parent_ID, Time_Posted, TTL, Waveform) VALUES ('$title', '$tags', '$uniqueName', '$UID', '$recipients', '$parent', '$postDate', '$ttl', '$waveform')";  

  $sql = "INSERT INTO Povs (Title, Tags, Data, Poster, Recipient, Private, Parent_ID, Time_Posted, TTL, Waveform) VALUES ('$title', '$tags', '$uniqueName', '$UID', '$recipients', '$private', '$parent', '$postDate', '$ttl', '$waveform')";

  mysqli_query($con,$sql);
  $error = mysqli_error();
  file_put_contents('/tmp/error', $error);
  unlink($imagePath);

  if (isset($parent)) {
    $sql = "UPDATE Povs Set Num_Replies = Num_Replies + 1 WHERE ID='$parent' ";
    mysqli_query($con,$sql);
  }

	//
	// Add this item to the Feed column for recipients and subscribers
	$sql = "UPDATE Users SET Feed=CONCAT('$uniqueName ',Feed) WHERE Subscribed_To LIKE '%$uname%'";
	mysqli_query($con,$sql);

    // send emails top the klattr recipients
    $sql = "SELECT Name, Email_Addr FROM Users WHERE Handle REGEXP '$recipient_regex' AND Activated = '1'";
    $sql_result = mysqli_query($con,$sql);
    while ($row = mysqli_fetch_array($sql_result)){
      if ($row['Name'] != "") {
        $emailText = file_get_contents("/data/klattr.com/www/includes/new_klattr_email_template");
        $emailText = str_replace("FULLNAME", $row['Name'], $emailText);
        $emailText = str_replace("SENDER", $uname, $emailText);
        $headers = "From: Klattr Team <administrator@klattr.com>\r\nReply-To: No Reply\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        mail($row['Email_Addr'], "You've Received a Klattr!", $emailText, $headers);
      }
    }

} else {
  header( 'Location: https://klattr.com' );
}
?>
