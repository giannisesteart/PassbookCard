<?php namespace Model\Passbook;


/* Class realizes Restapi cals */
class ModelPassbook
{
    private $connms ;
    private $log ;
	
    public function __construct($connms, $logfile )
    {
        $this->connms =$connms ;
        
        if( $this->connms === false ) //returns false
        {
         echo "Failed connection ";
	     die( print_r( sqlsrv_errors(), true));
        }
       $this->log = $logfile;
		
    }
	
	/* Validate authentication in Passbook */
	
	public function authvalid($authenticationtoken, $hotelcode, $serialnumber)
	{  
    	
	    $authenticationtoken = trim ($authenticationtoken);
		$sql = "SELECT * FROM PASSBOOK  WHERE hotelcode=" .$hotelcode . " AND serialnumber = '" .$serialnumber.
                                  		"' AND  authenticationtoken  = '" .$authenticationtoken  ."' ;"  ;

	    $stmt = sqlsrv_query($this->connms, $sql);
	    if( $stmt === false)
        {  $this->log->error ("Error in query preparation/execution:>RESTAPI");
           return FALSE;
        }

        if  ( sqlsrv_has_rows ($stmt ))  
	         return TRUE;
        else return FALSE;
		  
	
	}

	public function __destruct()
    {
       
    }
	
	
}
?>