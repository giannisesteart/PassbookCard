<?php
//$MYROOT = "C:/inetpub/vhosts/creationadv.gr/httpdocs/ihotelweb/vadmin"; 
$MYROOT = "../"; 
require_once ($MYROOT."/PHPUtil/phputil.php");
require_once ($MYROOT."/PHPUtil/config.php");
require_once ($MYROOT."/PHPUtil/common.php");

 
  
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
}


if( ! isset($_GET['hotelcode'])  ) {
        echo "Error in action: give hotelcode parameter.   ";
        die();
    } 
	
if( ! isset($_GET['serialnumber'])  ) {
        echo "Error in action: give hotelcode parameter.   ";
        die();
    } 	

	
$hotelcode= $_GET['hotelcode'] ;	
$serialnumber	= $_GET['serialnumber'];
  
 //select passbook
$sql = "SELECT  * FROM PASSBOOK where ( hotelcode= 1) AND ( serialnumber = '". $serialnumber . "' )  ;"  ;	
$stmt = sqlsrv_query($connms,$sql);
 if( $stmt === false)
  {
     echo "Error in query preparation/execution. no Categorie\n";
     die( print_r( sqlsrv_errors(), true));
  }
 $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
 $description = $rec ['description'] ;
 $passtype = $rec ['passTypeIdentifier'] ;
 $status = $rec ['status'] ;
 $foregroundcolor=$rec['foregroundcolor'];
 $backgroundcolor =$rec['backgroundcolor'];
 $labelcolor=$rec['labelcolor'];
 //select hotel dates
 $sql= "SELECT  * FROM HOTELS where code=".$hotelcode." ;"  ;	
 $stmt = sqlsrv_query($connms,$sql);
 if( $stmt === false)
  {
     echo "Error in query preparation/execution SubCategories.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  
 
 while ( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    
	echo  "<BR>". "PASSBOOK: ". $rec['title'] ." & SERIALNUMER: ".$serialnumber ;
	
     $data = array('hotelcode' => intval ($rec['code']),
                   'organizationname' =>   set ($rec['title']) ,
				   'description' => set ( $description),
				   'passTypeIdentifier' => $passtype,
				   'serialnumber' => $serialnumber,
				   'status' => $status,
				   'foregroundcolor'=> $foregroundcolor ,
                   'backgroundcolor' => $backgroundcolor,
				   'labelcolor' =>$labelcolor
				   );
				   
				   
	          		 
     $sql =   get_insert_query("PASSBOOK", $data);
			  //echo "<BR/>". $sql;
     $stmt1 = sqlsrv_query($connms,$sql);
 
     if( $stmt1 === false)
     {
       echo "Error in query preparation/execution insert SubCategories.\n";
       die( print_r( sqlsrv_errors(), true));
     }
	  
	 
 } //while 
 
 
 echo "<BR>FINISH: PASSBOOK READY <br/>";
 

 
?>

