<?php 
     //the passbok without blancs
	ob_clean ();
	
	$MYROOT = "C:/inetpub/vhosts/creationadv.gr/httpdocs/ihotelweb/vadmin"; 
 
    $FILE = $MYROOT."/passbookdata/" .$SERIALNUMBER.'/images'.$HOTELCODE.'/';
  
    $TempPath = 'temp/';
    $passname = "pass".$SERIALNUMBER;
    $ImagesFiles = array();//to set in passbook
   //  print_r ($ImagesFiles) ;
 
 
   /***** END Defines ***************/
 
    // create json fields at this order!!!*************
	   require_once ("passbook.php");
	   require_once ("passbookindex.php");
	   require_once ("passguest.php");
	   require_once ("passhotel.php");
	  
	 // You can add a rulesfile for specific calculations
	 // for a passbook json
	  if (file_exists ( "rules".$SERIALNUMBER.".php" ))
	        require_once ("rules".$SERIALNUMBER.".php");  
	
	
	// ready now !! create json
	  require_once ("data/json".$SERIALNUMBER.".php");
  
   // require_once ("data/json.php");
  
    
  
   // Debug
  //  if (TRUE) 
   {
	 
    require('./passkit.php');

    $Certificates = array(  'AppleWWDRCA'  => './certs/AppleWWDRCA.pem', 
                            'Certificate'  => './certs/'.$passTypeIdentifier.'.p12', 
                            'CertPassword' => '');
    
   // $ImageFiles = array('images/icon.png', 'images/icon@2x.png', 'images/logo.png');
   // $JSON = file_get_contents($_POST['json']) ;
     if(  isset($_GET['email'])) 
      require ("phpmail.php") ;
  
     if(  !isset($_GET['email'])) {
	    ob_clean ();
		echoPass(createPass($Certificates, $ImagesFiles, $JSON, $passname, $TempPath)); //safari
		
	 }
    
 
   
    //sleep(12);
   // m_uwait(12500);
    
  }
 

?> 
