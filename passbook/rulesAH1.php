<?php

 /* Rulesection */
 //This is the rules section for the specific Passbook Card
  //Here can calculate values or set integritychecks   
	 
	 //Rule expiresdate must formated than sec
	
	 if ($sec_c != NULL) {
	   $expiresdate1 =  DateTime::createFromFormat('d/m/Y', $sec_c);
      //echo $date->format('Y-m-d');
	 
	   
	   //new DateTime($sec_c);
	  // $expiresdate1->add(new DateInterval('P3D'));
   
       $expiresdate = $expiresdate1->format(DateTime::W3C);
     // $expiresdate = substr($expiresdate, 0, strpos($expiresdate, '+'));
 
	 }
 
 
 /* End Rules */
 
 
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
				   'logtext' =>  " BALANCE: ".$balance." OFFER: " . $offprice. " % ".$prim_a ,
				   'expiresdate' => $expiresdate ,
				   );
				   

				   
				   
	          		 
  $sql =   get_insert_query("PASSLOG", $data);

  $stmt = sqlsrv_query($connms,$sql);
   if( $stmt === false)
  {
     echo "Error in query preparation/execution in Passlog.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  sqlsrv_close ( $connms ) ;
 /*End Analytics */
 
  ?>