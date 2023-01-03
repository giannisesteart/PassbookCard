<?php
 require_once ("../PHPUtil/config.php");

 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
 }
  
 if( (! isset($_GET['hotelcode'])) || (! isset($_GET['guestcode']) ) ) {
        echo "Error in action parameters. Set hotel and ";
        die();
    }  
 $GUESTCODE =   $_GET['guestcode'];
 $HOTELCODE=   $_GET['hotelcode'];


$sql = "SELECT * FROM PASSLOG WHERE hotelcode= ". $HOTELCODE. " AND guestcode=" . $GUESTCODE. "  ;"  ;
echo $sql;  

$x =  ["Scrollable" =>'static' ];
$stmt = sqlsrv_query($connms, 
                     $sql, 
                     array() , 
                     $x );

 if( $stmt === false)
  {
     echo "Error in query preparation/execution guests .\n";
     die( print_r( sqlsrv_errors(), true));
  }
?>