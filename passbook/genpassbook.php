<?php require_once ("crypt.php");
	 
   if( (! isset($_GET['hotelcode'])) || (! isset($_GET['serialnumber']) ) ) {
        echo "Error in action parameters. Set hotel and ";
        die();
    }  

    if (! isset($_GET['guest'] ) ) {
		$GUESTCODE = "0"; //no Guest in DB
	 } else $GUESTCODE = crockford32_decode( $_GET['guest']);
	 
    $SERIALNUMBER = $_GET['serialnumber'];
    $HOTELCODE=  crockford32_decode( $_GET['hotelcode']);
	
	require ("genpassc.php");
?>