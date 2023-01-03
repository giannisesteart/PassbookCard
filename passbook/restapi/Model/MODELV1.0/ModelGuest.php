<?php namespace Model\Guest;


/* Class realizes Restapi calls */
class ModelGuest
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
	
	
	/* validate Guestcode and find the Hotelnumber*/
	
	public function hotelcode($guestcode)
	{    
		$sql = "SELECT * FROM GUESTS  WHERE code=" . $guestcode."  ;"  ;
        $stmt = sqlsrv_query($this->connms,$sql);
   
        if( $stmt === false)
         {  $this->log->error ("Error in query preparation/execution:>RESTAPI");
            return NULL;
         }
        if( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) 
		  if ($rec['hotelCode'] != NULL )
			  return ($rec['hotelCode']) ; 
		
		$this->log->error ("Hotelcode/or Guestcode for ". $guestcode." doesnt exists:>RESTAPI");
        return NULL;   
	
	}
	

	public function __destruct()
    {
       
    }
	
	
}
?>