<?php

    /*****Defines ***************/

	
	
   if( (! isset($_GET['hotelcode'])) || (! isset($_GET['serialnumber']) ) ) {
        echo "Error in action parameters. Set hotel and ";
       die();
    } 

	 if (! isset($_GET['guest'] ) ) {
		$GUESTCODE = "0"; //no Guest in DB
	 } else $GUESTCODE = $_GET['guest'];
	 
    $SERIALNUMBER = $_GET['serialnumber'];
    $HOTELCODE= $_GET['hotelcode'];

    
	$MYROOT = "C:/inetpub/vhosts/creationadv.gr/httpdocs/ihotelweb/vadmin"; 
	$MYROOT = "C:/xampp/htdocs";
    $FILE = $MYROOT."/passbookdata/" .$SERIALNUMBER.'/images'.$HOTELCODE.'/';
  
    $TempPath = 'temp/';
    $passname = "pass".$SERIALNUMBER;
    $ImagesFiles = array();//to set in passbook
   //  print_r ($ImagesFiles) ;
 
 
   /***** END Defines ***************/
 
    // create json fields at this order!!!*************
	 require_once ("passbook.php");
	 
	 require_once ("passguest.php");
	 
	 require_once ("passhotel.php");
	 require_once ("passbookindex.php");
	 require_once ("rules".$SERIALNUMBER.".php");
	 // importand create json
	  
	 // importand create json
	 require_once ("data/json".$SERIALNUMBER.".php");

  
    print_r ( $JSON); 
  
   // Debug
   if (FALSE) 
  {
	 
    require('./passkit.php');

    $Certificates = array(  'AppleWWDRCA'  => './certs/AppleWWDRCA.pem', 
                            'Certificate'  => './certs/'.$passTypeIdentifier.'.p12', 
                            'CertPassword' => '');
    
   // $ImageFiles = array('images/icon.png', 'images/icon@2x.png', 'images/logo.png');
   // $JSON = file_get_contents($_POST['json']) ;
  if(  isset($_GET['email'])) 
      require ("phpmail.php") ;
  if(  !isset($_GET['email'])) 
		echoPass(createPass($Certificates, $ImagesFiles, $JSON, $passname, $TempPath)); //safari
    
  
   
   // sleep(12);
   // m_uwait(12500);
    
  }
 

?> 
