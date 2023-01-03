<?php

 //This is the rules section for the specific Passbook Card
  //Here can calculate values or set integritychecks   
	 
	 //Rule expiresdate must formated than sec
	 
	 //$datecin = DateTime::createFromFormat('d/m/Y', $sec_c);
	 
	 $datetime1 = new DateTime($checkindate);
     $datetime2 = new DateTime($checkoutdate);
	 
	 if($datetime2 >$datetime1){
      $interval = $datetime2->diff($datetime1)->format("%a");
      $nights = $interval;
	  } else $nights=0 ;
	
	//Date expires by checkout
	 $expiresdate = $datetime2->format(DateTime::W3C);
	
	//echo "roomnr" .$roomnumber;
	
 
   
 /* *****Analytics *** LOGS FOR PASSBOOK ********************
  * The Aanalytics tracks the basic values
  * It set logtext that the client see in the guesttable
  * *****Analytics *** LOGS FOR PASSBOOK ********************/
  
  require_once ($MYROOT."/PHPUtil/common.php");
  $connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
  if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
  }
  
  $data =   array('hotelcode' => $HOTELCODE,
                   'guestcode' =>   $GUESTCODE ,
				   'serialnumber' => $SERIALNUMBER,
				   'logtext' =>  " ROOM: ".$typeofroom." RESERVATION PRICE: " . $reservationprice. " NIGHTS: ".$nights . " CHECKIN:".$checkindate.  " To "  .$checkoutdate ,
				   'expiresdate' =>  $expiresdate 
				   );
				   

				   
				   
	          		 
  $sql =   get_insert_query("PASSLOG", $data);

  $stmt = sqlsrv_query($connms,$sql);
   if( $stmt === false)
  {
     echo "Error in query preparation/execution PASSLOG.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  sqlsrv_close ( $connms ) ;
 /*End Analytics */
 
 
  ?>