<?php
//if( isset($_GET['email']))
{

       $from_email = 'info@esteart.gr'; //sender email
      // $recipient_email = 'manager@abouthotelier.com'; //recipient email
	   $recipient_email = 'esteart@esteart.gr'; //recipient email
	   $user_email ='info@esteart.gr' ;
       $subject = 'Test mail'; //subject of email
       $message = 'This is body of the message'; //message body
      
  //	  $filename = 'hotelpass' . '.pkpass';
	   
	   $filename = $passname.'.pkpass';
 	   $encoded_content =  emailPass(createPass($Certificates, $ImagesFiles, $JSON, $passname, $TempPath));
	 
    //read from the uploaded file & base64_encode content for the mail
    
        $boundary = md5("sanwebe"); 
        //header
        $headers = "MIME-Version: 1.0\r\n"; 
        $headers .= "From:".$from_email."\r\n"; 
        $headers .= "Reply-To: ".$user_email."" . "\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n"; 
        
        //plain text 
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n"; 
        $body .= chunk_split(base64_encode($message)); 
        
        //attachment
		//mime_content_type
		 
        
		 $body .= "--$boundary\r\n";
         $body .="Content-Type:application/vnd.apple.pkpass; name=\"".$filename."\"\r\n";
       //  $body .="Content-Disposition: attachment; filename=\"".$file_name."\"\r\n";
		 
		
		 $body .="Content-Disposition: attachment;\n" . " filename=\"".$filename."\"; size=". strlen( $encoded_content).";\n";
		 $body .= "X-Attachment-Id: ".rand(1000,99999)."\r\n\r\n"; 
         $body .= $encoded_content."\r\n"; 
		 $body .= "--$boundary--";
		
		 
    
    $sentMail = @mail($recipient_email, $subject, $body , $headers);
    if($sentMail) //output success or failure messages
    {       
        die('Thank you for your email to '.$recipient_email);
    }else{
        die('Could not send mail!to '.$recipient_email. ' Please check your PHP mail configuration.');  
    }

}
?>