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

echo '*********************' ;



/*Support standard HTTP caching on this endpoint: Check for the If-Modified-Since header,
 * and return HTTP status code 304 if the pass has not changed.
 */

 if ( isset($_SERVER['If-Modified-Since'])) {
		  $ts  =  $_SERVER['If-Modified-Since'];
	      $dt  = new DateTime("@$ts"); 
	      $updatedsince = $dt->format('Y-m-d H:i:s');
		  $updatedsince ="2016-01-31 12:40:25"; //achtung!
		 if ( ! $registerstable->modified_serial ("6253", "AH3",$updatedsince) ){
		    closeconn($connms);
		    http_response_code(503);
			exit; 
		 }
	} 
 
 
	     
		 $updatedsince ="2016-01-31 12:40:25";
		 if ( $registerstable->modified_serial ("6253", "AH3",$updatedsince) )
			 echo "found!!" ;
		 else echo "not found!!"; 
 

sqlsrv_close ($connms ) ;

?>