<?php namespace Model\Devices;


/* Class realizes Restapi calls */
class ModelDevices
{
    private $connms ;
    private $log ;
	
    public function __construct($connms, $logfile )
    {
        $this->connms =$connms ;
        $this->log = $logfile;
		
        if( $this->connms === false ) //returns false
        {
		 $this->log->error ("Failed connection:RESTAPI");	
         echo "Failed connection ";
	     die( print_r( sqlsrv_errors(), true));
        }
       	
    }
	
	
	// give the device for the pair
	
	public function deviceidforguest( $guestcode, $deviceLibraryIdentifier)
	{   $sql = "SELECT * FROM DEVICES  WHERE guestcode=" . $guestcode." AND deviceLibraryIdentifier='".$deviceLibraryIdentifier."'  ;"  ;
        $stmt = sqlsrv_query($this->connms,$sql);
   
        if( $stmt === false)
         {  $this->log->error ("Error in query preparation/execution SELECT DEVICES :>RESTAPI");
            return NULL;
         }
		 	 
        if( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
		  if ($rec['id'] != NULL )
			  return ($rec['id']) ; 
		
		//$this->log->info ("Device for ". $guestcode." doesnt exists:>RESTAPI");
        return NULL; 
	}
	
	
	/* Insert new device */
	
	public function insertdevice($guestcode, $pushtoken, $deviceLibraryIdentifier)
	{    
	 
		$sql =  "INSERT INTO DEVICES ( guestcode, pushtoken, deviceLibraryIdentifier) 
		          VALUES (". $guestcode .", '" .$pushtoken."', '".$deviceLibraryIdentifier."');";
        $stmt = sqlsrv_query($this->connms,$sql);
   
        if( $stmt === false)
         {  $this->log->error ("Error in query preparation/execution: INSERT DEVICETOKEN >RESTAPI");
            return NULL;
         }
		 
		  return ($this->deviceidforguest( $guestcode, $deviceLibraryIdentifier));
	
	}
	

	public function __destruct()
    {
       
    }
	
	
}
?>