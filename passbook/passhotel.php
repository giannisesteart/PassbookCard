<?php

require_once ($MYROOT."/PHPUtil/phputil.php");
 
//******* open and select data from Passbook 
require_once ($MYROOT."/PHPUtil/config.php");
		 	 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false




if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
}
  
$sql = "SELECT * FROM HOTELS WHERE code=" . $HOTELCODE. ";"  ;
 
  
 //************************************************
//$rec is ready fill the JSON with  data from DB PASSBOOKINDEX
//********************************************************
  
	  
	
$stmt = sqlsrv_query($connms,$sql);
   
if( $stmt === false)
  {
     echo "Error in query preparation/execution.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  
  
  /*
  out> => code => int

=> title => nvarchar
=> hotelOwner => nvarchar

=> url => nvarchar

=> address => nvarchar

=> phoneNumber => nvarchar

=> faxNumber => nvarchar

=> email => nvarchar

=> latitude => nvarchar

=> longitude => nvarchar

=> website => nvarchar


*/
 

  
  if( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
   
 
	
      $hotelcode =           $rec['code']  ;  
      $hotelname =         ("n/a" !=  $rec['title'] )        ? ms_escape_string  ($rec['title'])    : "";
	  $hotelowner =        ("n/a" !=  $rec['hotelOwner'] )    ? ms_escape_string ($rec['hotelOwner'])    : "";  
   //   $hotelurl =          ("n/a" !=  $rec['hotelurl'] )      ? ms_escape_string ($rec['hotelurl'])    : "";  
      $hoteladress =       ("n/a" !=  $rec['address'] )       ? ms_escape_string ($rec['address'])    : ""; 
	  $hotelphone =        ("n/a" !=  $rec['phoneNumber'] )   ? ms_escape_string ($rec['phoneNumber'])    : "";
	  $hotelfax =          ("n/a" !=  $rec['faxNumber'] )     ? ms_escape_string ($rec['faxNumber'])    : "";
  	  $hotelemail=         ("n/a" !=  $rec['email'] )         ? ms_escape_string ($rec['email'])       : "";
      $hotellatitude=      ("n/a" !=  $rec['latitude'] )      ? ms_escape_string ($rec['latitude'])    : "";
	  $hotellongitude =    ("n/a" !=  $rec['longitude'] )     ? ms_escape_string ($rec['longitude'])    : "";
	  $hotelwebsite   =     ("n/a" !=  $rec['website'] )       ? ms_escape_string ($rec['website'])      : "";
	   
	 
	  
   //debug
  if (FALSE) {  
     echo  $hotelcode . "<BR>"   ;
     echo    $hotelname . "<BR>" ;
	 echo   $hotelowner. "<BR>" ;     
     echo  "hotelurl".$hotelurl. "<BR>" ;         
     echo  "".$hoteladress. "<BR>" ; 
	 echo   $hotelphone . "<BR>";
	 echo   $hotelfax . "<BR>";         
     echo  $hotelemail . "<BR>";
	 echo  $hotellatitude. "<BR>"  ;
	 echo $hotellongitude."<br>" ;
	 echo  $hotelwebsite."<br>" ;

  } //end debug
  
  
  } //if
     //*** close
     sqlsrv_close ( $connms ) ;
  ?>