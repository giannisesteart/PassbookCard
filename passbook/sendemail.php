<?php 
 /*
 /* Email that sends Passbook
  */
  
  require_once ("crypt.php");
 

  function sendemail ($guestcode, $serialnumber,$hotelcode)
  {
     global $guesttable, $hoteltable;
	
	 
	 //crypt hotelcode & guestcode
	 //Key used o genpassc.php for decode!!not change!!
    global $keyh, $keyg ;
	
	
//To Encrypt:
    $crypthotel =crockford32_encode("".$hotelcode);
	 
	$cryptguest = crockford32_encode("".$guestcode) ;
	 
	
    $guest= $guesttable-> guestdata($guestcode);
	if ($guest ==NULL) {
            return FALSE;
    }	
	
	$email =$guest['email'];
	if ($email == NULL && $email == 'n/a') {
		echo "Can't send email for Guest:".$guestcode ." "; 
		return FALSE ;
	}
	
	$name = ($guest['Surname'] !='n/a' &&  $guest['Surname'] !=NULL) ? $guest['Surname'] : "";
	
	$hotel=$hoteltable-> hoteldata($hotelcode);
	if ($hotel ==NULL) {
            return FALSE;
    }
	
    $title =$hotel['title'];
	$tmpIcon = $hotel['icon'];
	$phonenumber=$hotel['phoneNumber'] ;
	$htlemail=$hotel['htlemail'] ;
	if ($htlemail=='n/a'){
	  echo "Can't send email :Hotelmail corrupt:".$htlemail;
	  return FALSE;
    }
	
	
	$passlink = 'hotelcode='.$crypthotel.'&guest='.$cryptguest.'&serialnumber='.$serialnumber;
	$subject = 'Passbook from Hotel: '. $hotel['title'];
	
	$body = file_get_contents ("./template/passbooktemplate.html") ;
	$body = str_replace( "{passlink}", $passlink, $body);
	$body = str_replace( "{title}", $title, $body);
	$body = str_replace( "{htlemail}", $htlemail, $body);
    $body = str_replace( "{phonenumber}", $phonenumber, $body);
	$body = str_replace( "{tmpIcon}", $tmpIcon, $body);
	$body = str_replace( "{lastname}", $name, $body);
	$body = str_replace( "{serialnumber}", $serialnumber, $body);
	
	
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
	$mail -> CharSet = "UTF-8";
	
    // Set PHPMailer to use the sendmail transport
    //$mail->isSendmail();
    //Set who the message is to be sent from
    $mail->setFrom($htlemail);
    //Set an alternative reply-to address
    $mail->addReplyTo($htlemail, 'Hotel Reply');
    //Set who the message is to be sent to
    $mail->addAddress($email);
     //Set the subject line
     $mail->Subject = $subject;
    //Read an HTML message body from an external file, convert referenced images to embedded,
     //convert HTML into a basic plain-text alternative body
     $mail->msgHTML($body);
    //Replace the plain text body with one created manually
   
   // echo "sendemail>>".$guestcode."from".$htlemail."to".$email;
	
   //send the message, check for errors
    if (!$mail->send())  return FALSE;
	 else   return TRUE;
  
 }/// end  
 
	
?>