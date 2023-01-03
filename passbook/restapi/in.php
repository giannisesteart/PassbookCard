<?php

require_once ("../../PHPutil/MyLogPHP/MyLogPHP.class.php");
require_once ("../../PHPUtil/config.php");
$connms = sqlsrv_connect ($mssql_host , $connectioninfo);
require_once __DIR__.'/Model/ModelPassbook.php';
require_once __DIR__.'/Model/ModelGuest.php';
require_once __DIR__.'/Model/ModelDevices.php';
require_once __DIR__.'/Model/ModelRegisters.php'; 
require_once __DIR__.'/Model/Defines.php'; 

$log = new MyLogPHP ("../logs/Passbook.log.csv");
$passbooktable = new \Model\Passbook\ModelPassbook($connms, $log);
$guesttable = new \Model\Guest\ModelGuest($connms, $log);
$devicetable = new \Model\Devices\ModelDevices($connms, $log);
$registerstable = new \Model\Registers\ModelRegisters($connms, $log);
 
echo "this is a test <br/>";
echo UPDATE_CARD ;

if ($passbooktable->authvalid ("jjjjjjj",1,"AH1") ) echo "true"; else echo "false";

 echo "HOTEL =" . $guesttable->hotelcode ("6253") ;

//$log->error ("Error in query preparation/execution:>RESTAPI");
 //echo "insertdevice>>" . $devicetable-> insertdevice("6253", "55f281b7922a94ab87739b662084654b4e903f5d960831060f8e6cb64d953a7b", "123") ;

if ($devicetable->deviceidforguest ("6253" ,"123")==NULL) echo "NULL" ;
else echo "Device is not in ";
echo "My device is  = ". $devicetable->deviceidforguest ("6253","123") ;

 $registerpair = $registerstable->isregistered_device("6253", "AH3");
 
 echo "registerd".$registerpair['isregistered']."<br>"; 
 echo "deviceid".$registerpair['deviceid']."<br>";
 echo "status".$registerpair['status']."<br>";
  
 $s = date_format( $registerpair['last_updated'], "'Y-m-d H:i:s'" );  
 //$dt  = new DateTime($s); 
 //$up = $registerpair['last_updated']->format('Y-m-d H:i:s');
 
echo "lastupdated".$s."<br>";

// deviceidforguest
$registerstable->update_registration ("6253", "AH3", date('Y-m-d H:i:s'));
//$registerstable->insert_registration (  "25149", "AH2", UPDATE_CARD);

echo "updatet";
 


sqlsrv_close ($connms ) ;

?>