<?php
/*
 *  This is the send interface Modul for all Passbooks sends.
 *  The Modul checks and update the Registration status
 *  Decide if is push to send or email
 *  Sends push or email
 */
 
     require_once ("../PHPutil/MyLogPHP/MyLogPHP.class.php");
     require_once ("../PHPUtil/config.php");
     require_once  ( '../PHPUtil/PHPmailer/PHPMailerAutoload.php');
	 require_once  ('../PHPUtil/ApnsPHP/ApnsPHP/Autoload.php');
	 ;
	 $connms = sqlsrv_connect ($mssql_host , $connectioninfo);
	  
	 function closeconn($connms) { 
         sqlsrv_close ( $connms ) ;
     }
   
     require_once __DIR__.'/restapi/Model/ModelPassbook.php';
     require_once __DIR__.'/restapi/Model/ModelGuest.php';
	 require_once __DIR__.'/restapi/Model/ModelHotel.php';
     require_once __DIR__.'/restapi/Model/ModelDevices.php';
     require_once __DIR__.'/restapi/Model/ModelRegisters.php';
	 require_once __DIR__.'/restapi/Model/Defines.php';
	 
     $log = new MyLogPHP ("logs/Passbook.log.csv");
     $passbooktable    = new \Model\Passbook\ModelPassbook($connms, $log);
     $guesttable       = new \Model\Guest\ModelGuest($connms, $log);
	 $hoteltable       = new \Model\Hotel\ModelHotel($connms, $log);
     $devicetable      = new \Model\Devices\ModelDevices($connms, $log);
     $registerstable   = new \Model\Registers\ModelRegisters($connms, $log);
	 
	 require_once  ( 'sendemail.php');
     //require_once  ( 'sendAPN.php');
 
     function actualtime () { 
       $dt = new DateTime();
       return ($dt->format('Y-m-d H:i:s'));
     }
 
    if (! isset ($_POST['serialnumber'] ) || !isset ($_POST['hotelcode']) || ! isset ($_POST['guests'] )) 
	{
		$log->error (" No data send ");
		echo "Is die : not correct parametes";
		die ();
	}
	$serialnumber =$_POST['serialnumber'];
	$hotelcode = $_POST['hotelcode'];
	$guests =$_POST['guests'];
	$passbookstatus = $passbooktable->passbookstatus ($hotelcode, $serialnumber);
	if ( ! in_array($passbookstatus, [ NO_UPDATE_CARD , UPDATE_CARD] )  ) {
        $log->error (" Passbook not correct status:DB inconsistent ");
		echo "Is die : not correct status";
		die ();
	 }	 
	
	//for ech guest sen passbook
	foreach ($guests as $guestcode) {
		
	 //Fetch register entry if exists
	 $registrationpair = $registerstable->isregistered($guestcode, $serialnumber, NULL);
    
	
	// IF is not registered
     if ($registrationpair['registrationid'] ==NULL) {
		 
		 if (sendemail ($guestcode, $serialnumber,$hotelcode))
           $registerstable->insert_registration ($guestcode, $serialnumber, $passbookstatus, actualtime ());
	     else  echo " Unable to send for guest:".$guestcode ;
	     
		 
	 } else { //is registered
		switch ($registrationpair['status']) {
         case NO_UPDATE_CARD :
		 if (sendemail ($guestcode, $serialnumber,$hotelcode)) {
           $registerstable->update_registration ( $guestcode, $serialnumber, actualtime ());
		   } else echo " Unable to send for guest:".$guestcode ;
         break;
         case UPDATE_CARD :
           //if ( sendPush ($guestcode, $registrationpair['deviceid'] ))
		   {
		    $registerstable->update_registration ( $guestcode, $serialnumber, actualtime ());	
		   } //else echo " Unable to send for guest:".$guestcode ;
          break;
		 
        default: //another status
		  echo " Not send for ".$guestcode." STATUS IS ".$registrationpair['status'];
         } //switch  
	 } //else
     echo $guestcode."\n";
	
	
	 }//foreach


	
?>