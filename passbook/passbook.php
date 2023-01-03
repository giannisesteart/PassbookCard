<?php
 
require_once ($MYROOT."/PHPUtil/phputil.php");
 
//******* open and select data from Passbook 
require_once ($MYROOT."/PHPUtil/config.php");
		 
		 
/* Function to Form barcode !! 
*/ 

function setcustomerid ($serialnr, $guestc,  $hotelc ) {
  
  $srnr = substr ( ms_escape_string($serialnr) , 2);

  
  switch (strlen($srnr))  {
    case 1:
        $srnr ="0".$srnr;
        break;
    case 2:
        break;
    default:
        echo "Error in passbook.php >>" .strlen($srnr). " this serialummer must be 1 or 2 digits";
	    die();   
        break;
   }
  
  if ( ( strlen ($hotelc) > 3)  || (strlen ($guestc ) >5) )  
  {     echo "Error in passbook.php. hotelcode or guestcode to many digits";
	    die();
  } 
  
  
   while ( strlen ($hotelc) < 3 ) $hotelc= "0". $hotelc ;
   while ( strlen ($guestc) < 5 ) $guestc= "0".$guestc ;
   
   $barcode = $srnr . $hotelc . $guestc; 
   return ( $barcode) ;
   
}	
		 
		 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
if( $connms === false )
{
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
}
  
$sql = "SELECT * FROM PASSBOOK  WHERE hotelcode=" . $HOTELCODE. " AND serialnumber = '" .$SERIALNUMBER."' ;"  ;

	  
	
$stmt = sqlsrv_query($connms,$sql);
   
if( $stmt === false)
  {
     echo "Error in query preparation/execution PB 1.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  
  
if  ( ! sqlsrv_has_rows ($stmt )) {
	   echo "Hotel is unknown \n";
       die ();
  } 
  
  
   //************************************************
  //$rec is ready fill the JSON with  data from DB
   $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	  
	  $ImagesFiles = array();
     
 	 if ("n/a" != ($rec['background'])) 
          array_push( $ImagesFiles, $FILE.$rec['background'] );
 
      if ("n/a" != ($rec['background2x'])) 
           array_push( $ImagesFiles, $FILE.$rec['background2x'] );
  
      if ("n/a" != ($rec['logo'])) 
          array_push( $ImagesFiles, $FILE.$rec['logo'] );
 
      if ("n/a" != ($rec['logo2x'])) 
          array_push( $ImagesFiles, $FILE.$rec['logo2x'] );
 
      if ("n/a" != ( $rec['icon'])) 
        array_push( $ImagesFiles, $FILE.$rec['icon'] );
 
      if ("n/a" != ($rec['icon2x'])) 
         array_push( $ImagesFiles, $FILE.$rec['icon2x'] );
 
      if ("n/a" != ($rec['strip'])) 
           array_push( $ImagesFiles, $FILE.$rec['strip'] );
 
      if ("n/a" != ($rec['strip2x'])) 
          array_push( $ImagesFiles, $FILE.$rec['strip2x'] );  
     
	 if ("n/a" != ($rec['thumbnail'])) 
           array_push( $ImagesFiles, $FILE.$rec['thumbnail'] );
 
      if ("n/a" != ($rec['thumbnail2x'])) 
          array_push( $ImagesFiles, $FILE.$rec['thumbnail2x'] ); 
	 
      /* 
	  $backfieldskey =       ("n/a" !=  $rec['backfieldskey'] )     ? $rec['backfieldskey']    : "";
	  $primaryfieldskey =    ("n/a" !=  $rec['primaryfieldskey'] )  ? $rec['primaryfieldskey'] : "";
	  $secondaryfieldskey =  ("n/a" != $rec['secondaryfieldskey'] ) ? $rec['secondaryfieldskey'] : "";
	  */
	  $passid =  $rec['ID'];
	  $authenticationtoken =  ("n/a" !=  $rec['authenticationtoken'] )   ? $rec['authenticationtoken']    : "n/a";
	  
	  $foregroundcolor =     ("n/a" !=  $rec['foregroundcolor'] )   ?  hex2rgb ($rec['foregroundcolor'])  : "" ;
      $backgroundcolor =     ("n/a" !=  $rec['backgroundcolor'] )   ?  hex2rgb ($rec['backgroundcolor'] ) : "";
      $labelcolor =          ("n/a" !=  $rec['labelcolor']      )   ?  hex2rgb ($rec['labelcolor']  )   : "";
     
	  $logotext  =            ("n/a" != $rec['logotext'] )         ? $rec['logotext']  : "";
      $organizationname  =    ("n/a" != $rec['organizationname'] ) ? $rec['organizationname']  : "";
      $description  =         ("n/a" != $rec['description']     )  ? $rec['description']  : "";
	 
	 // set the other specific fields
	  $barcode  =   $rec['barcode'] ;
	  
	  $passTypeIdentifier =$rec['passTypeIdentifier'];
	  
	  $customerid = setcustomerid ($SERIALNUMBER,$GUESTCODE, $HOTELCODE) ;
	 
	 /*
	 $expiresdate1 = new DateTime('NOW');
	 $expiresdate1->add(new DateInterval('P3D'));
     //$substring = substr($string, 0, strpos($string, ' '));
     $expiresdate = $expiresdate1->format(DateTime::W3C);
  
     */
     //*** close
     sqlsrv_close ( $connms ) ;
  ?>