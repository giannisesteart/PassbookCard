<?php

require_once ($MYROOT."/PHPUtil/phputil.php");
 
//******* open and select data from Passbook 
require_once ($MYROOT."/PHPUtil/config.php");
		 	 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false




if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
}
  
$sql = "SELECT * FROM GUESTS  WHERE code=" . $GUESTCODE."  ;"  ;
 
$stmt = sqlsrv_query($connms,$sql);
   
if( $stmt === false)
  {
     echo "Error in query preparation/execution guests .\n";
     die( print_r( sqlsrv_errors(), true));
  }
  


   
  if( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    
   //************************************************
 
 //$rec is ready fill the JSON with  data from DB
   
/*	  code => int

=> hotelCode => int => title => nvarchar

=> guestName => nvarchar

=> guestNameGR => nvarchar

=> guestSurname => nvarchar

=> guestSurnameGR => nvarchar

=> nationality => nvarchar

=> age => nvarchar

=> checkedIn => tinyint

=> checkInDate => datetime2

=> checkOutDate => datetime2

=> roomNumber => int

=> email => nvarchar

=> password => nvarchar

=> mobileNumber => nvarchar

=> notes => nvarchar

=> status => nvarchar

=> referer => nvarchar

=> reservationPrice => nvarchar

=> preCheckInEmailSent => bit

=> activeGuest => int

=> lastActive => datetime

=> Channel => varchar

=> Details => varchar

=> Booked => datetime

=> balance => decimal

=> offprice => int

=> balance1 => int
*/
	  

  //************ Set guestdata
	
      $guestcode =           $rec['code']  ;  
      $guestname =           ("n/a" !=  $rec['guestName'] )        ? ms_escape_string ($rec['guestName'])    : "";
	  $guestsurname =        ("n/a" !=  $rec['guestSurname'] )     ? ms_escape_string ($rec['guestSurname'])    : "";  

  	  $checkindate =         date_format($rec['checkInDate'],"d-m-Y" ); 
	  $checkoutdate =        date_format($rec['checkOutDate'],"d-m-Y" ); //date("d-m-Y",strtotime($rec['checkOutDate'])); 	
	 
      $reservationprice =      ("n/a" !=  $rec["reservationPrice"] ) ? number_format($rec["reservationPrice"], 2, '.', '')     : 0;
	  
	  $checkedin =            $rec['checkedIn']  ;
      $roomcode =             $rec['roomNumber']  ;
	  $booked =               $rec['Booked']  ;
	  $guestemail =          ("n/a" !=  $rec['email'] )     ? ms_escape_string ($rec['email'])    : "";
	  $bookingid =         ("n/a" !=  $rec['password'] )     ? ms_escape_string ($rec['password'])    : "";
	  
	  $roomType =          ("n/a" !=  $rec['roomType'] )     ? ms_escape_string ($rec['roomType'])    : "";
	  $roomName =          ("n/a" !=  $rec['roomName'] )     ? ms_escape_string ($rec['roomName'])    : "";
	
   	  $offprice =           ( ! is_null ( $rec['offprice'] ) )     ? $rec['offprice']   : 0;
      $balance =            ( ! is_null ( $rec['balance'] ) )     ? round (floatval ($rec['balance']),2)    : 0;
	 
	   
 
	
	//******************And set Rooms
	   $typeforoom ="";
       $roomnumber ="";
     
	  if  (isset ($roomcode)) {
         $sql = "SELECT * FROM ROOMS  WHERE code =" . $roomcode."  ;"  ;
        $stmt = sqlsrv_query($connms,$sql);
        if( $stmt === false)
        {
         echo "Error in query preparation/execution in passguests Rooms.";
         die( print_r( sqlsrv_errors(), true));
        }
  
       if( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
	      $typeofroom = $rec ["typeofroom"] ;
	      $roomnumber = $rec ["roomNumber"] ;
       }
    }
	 
     //webhotelier priviligiert
  
      if ( $roomName <>  "") $typeofroom = $roomName;
	
	 
	
   //debug
  if (FALSE) {  
     
     echo  $guestcode    ;
     echo    $guestname  ;
	 echo   $guestsurname;     
     echo  "".$checkindate;         
     echo  "".$checkoutdate; 
	 echo $checkedin ;         
     echo  $roomnumber;
	 echo  $booked  ;
	 echo $guestemail."<br>" ;
	 echo  $bookingid."<br>" ;
	 echo "**********************" ; 
	 echo $offprice."<br>" ;
     echo $balance."<br>"  ;
	 echo $expiresdate."<br>";
	
  } //end debug
  
  
  } //if
  
  
     //*** close
     sqlsrv_close ( $connms ) ;
  ?>