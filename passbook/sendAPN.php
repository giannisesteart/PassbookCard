
<?php
/*
 *  Send push signal to the passbook device
 */


 

  function sendPush ($guestcode,$deviceid, $passtype)
  {
     global $devicetable, $log ;
 
	
    $device= $devicetable->pushdata($deviceid);
	
	if ($device ==NULL ||$device['pushtoken']==NULL) {
		    $log->error ("Deviceid incossistent: ".$deviceid."for Guest: ".$guestcode) ;
            return FALSE;
    } 
	
	$pushtoken =$device['pushtoken'];
   //test $pushtoken="55f281b7922a94ab87739b662084654b4e903f5d960831060f8e6cb64d953a7b";
  //echo $pushtoken ;
  
  if ($device['pushService'] == 'ios') { //ios push service
	  
    $push_service = new ApnsPHP_Push(ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION , './certs/pass.com.ihotel.public.pem');
    $push_service->setRootCertificationAuthority('./certs/entrust_root_certification_authority.pem');
    $push_service->connect();
 
    $message = new ApnsPHP_Message($pushtoken);

 
// Set a custom property
    $message->setCustomProperty('', 1);

// Set the expiry value to 30 seconds
    $message->setExpiry(30);

// Set the "View" button title.

    $push_service->add($message);

    $push_service->send();
 
    $push_service->disconnect();

	
    $aErrorQueue = $push_service->getErrors();

    if (!empty($aErrorQueue)) {
				        var_dump($aErrorQueue);
						$log->error (var_dump($aErrorQueue).">>Push for the pushtoken". $pushtoken) ;
						return FALSE ;
						
     }
    else return TRUE;

  } else { // attido push service 
      
	   
       $URL = $device['pushService']."v1/pushUpdate" ; 
	 
       $data = array ( "passTypeID" => $passtype ,  "pushToken"=>  $pushtoken );
       $data_string = json_encode($data);
       $ch = curl_init($URL);
	   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data_string)));  
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
	  
	   
	   //session_write_close(); //dead lock prevent if session. Here is not session reqiered
	   $response =curl_exec($ch);
	  
	   $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	   
	   if ($httpCode ==200) {
		  curl_close($ch); 
		  return TRUE;
	   }else{ 
		      $log->error ( 'Errno' .curl_errno($ch) .  '<br/>Error'. curl_error($ch) ." Guestcode:".$guestcode ); 
		      echo "Cant send Guestcode:".$guestcode ;
			  curl_close($ch); 
		      return FALSE;
       }   
  
    } // attido
	  
	
	
	
  }	// end function

	


?>