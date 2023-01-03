 <?php 
/*
 * Realizasion of passkit get serialnumbers
 * webServiceURL/version/devices/deviceLibraryIdentifier/registrations/passTypeIdentifier?passesUpdatedSince=tag
 *
 */   
 
	 require_once ("../../PHPutil/MyLogPHP/MyLogPHP.class.php");
     require_once ("../../PHPUtil/config.php");
	 $connms = sqlsrv_connect ($mssql_host , $connectioninfo);
	 function closeconn($connms) {
         sqlsrv_close ( $connms ) ;
     }
	 
     require_once __DIR__.'/Model/ModelRegisters.php';
	 require_once __DIR__.'/Model/ModelDevices.php';
	 
     $log = new MyLogPHP ("../logs/Passbook.log.csv");
     $registerstable   = new \Model\Registers\ModelRegisters($connms, $log);
     $devicetable      = new \Model\Devices\ModelDevices($connms, $log);
	
	
	(isset ($_GET ['guest'])) ? $guestcode = $_GET ['guest'] : $log->error ("Error Get parameter not found:>RESTAPI"); 
	(isset ($_GET ['deviceLibraryIdentifier'])) ? $deviceLibraryIdentifier = $_GET ['deviceLibraryIdentifier'] : $log->error ("Error Get parameter not found:>RESTAPI");
	
	
	if ( isset($_GET['passesUpdatedSince'])) {
		  $ts  =  $_GET['passesUpdatedSince'];
	      $dt  = new DateTime("@$ts"); 
	      $updatedsince = $dt->format('Y-m-d H:i:s');
	} else $updatedsince =NULL ; 	 
	
		 
	/*************************************/
	if ( TRUE) { //debug
	ob_start();
	echo "Getserial numbers>>" ;
    echo "<br/>Customer code >" . $_GET ['guest'];
	echo "Date is " ; echo "**>>".$updatedsince;  echo "end";
  
   $deviceid = $devicetable->deviceidforguest ($guestcode, $deviceLibraryIdentifier); 
   $serialnumbers   =  $registerstable->lookupserials($guestcode,$updatedsince, $deviceid) ;
    var_dump ($serialnumbers);
   
   $content = ob_get_contents();
	$x =file_get_contents('memosend.txt');
    $fp = fopen("memosend.txt", 'w');
    if($fp) {
      fwrite($fp, $x."*****************/r/n".$content);
      fclose($fp);
	   
     } 
	 
	  ob_clean () ;
	} 
 
	
	 
	/**********end Debug ***********/
	

/*If there are matching passes, returns HTTP status 200 with a JSON dictionary with the following keys and values:
lastUpdated (string)
The current modification tag.
serialNumbers (array of strings)
The serial numbers of the matching passes.
If there are no matching passes, returns HTTP status 204.
Otherwise, returns the appropriate standard HTTP status. */
    
	// this array should be populated by  database.
	
	$deviceid = $devicetable->deviceidforguest ($guestcode, $deviceLibraryIdentifier); 
	if ($deviceid==NULL) 
	{   
        closeconn($connms);
		http_response_code(503);
		exit;
	}
	
	$serialnumbers   =  $registerstable->lookupserials($guestcode,$updatedsince,$deviceid ) ;
	
	if ($serialnumbers['error']) 
	{   
        closeconn($connms);
		http_response_code(503);
		exit;
	}
	
	$serialsArray = $serialnumbers ['serialnumbers'] ;	
	
	
	
    if (count($serialsArray ) >0 ) {
	  header('Content-Type: application/json');
      echo json_encode(array('lastUpdated' => (string)time(), 
                             'serialNumbers' => $serialsArray));  

   							 
	  http_response_code(200);
   } else {
   // No serials need updating so send a 204 response  
      http_response_code(204);
    }    
	
	
	closeconn($connms);

?>