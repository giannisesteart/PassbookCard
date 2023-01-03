<?php
//"authenticationToken": "vxwxd7J8AlNNFPS8k0a0FfUFtq0ewzFdc",

$JSON = '{
  "barcode": {
	"altText": "'. $customerid. '",
    "format": "'. $barcode. '",
    "message": "'. $customerid. '",
    "messageEncoding": "iso-8859-1"
  },
  "description": " '.$description.' " ,
  "coupon": {
	
	 "headerFields" : [
      {
        "key" : "header",
		"label" : "BALANCE",
        "value" : '.  $balance . ',
        "currencyCode" : "EUR",
		"changeMessage" : "You have balance yet %@ EUR"
      }
	  
    ],
	
	 
    "backFields" : [
     
	 {  "key" : "nameBack",
        "label" : "Profile",
        "value" : " '. $guestname. " ".$guestsurname.'\r\n'.$guestemail . '"
      } ,
	  
	   { "key" : "bookingid",
        "label" : "Reservation Id",
        "value" : "'   . $bookingid.  '"
      } ,
	  
	   
	  { "key" : "roomnr",
        "label" : "Room number",
        "value" : "'  . $roomnumber  .  '"
      } ,
	  
	  
	  { "key" : "expdate",
        "label" : "Expires Date" ,
        "value" : "'  . $sec_c  .  '"
      } ,
	  
	   
	  { "key" : "offer",
        "label" : "Offer",
        "value" : "'  . $back_a  .  '"
      } ,
	  
	  { "key" : "contact",
        "label" : "Contact",
        "value" : "' . $hotelname  .  '\r\n'. $hoteladress .   '\r\n'.$hotelphone . '\r\n'. $hotelwebsite .  '\r\n'. $hotelemail .  '"
      } ,
	    
	  { "key" : "terms",
        "label" : "Terms",
        "value" : "'. $back_c  .  '"
      } ,
	  
	  
	   { "key" : "lastmessage",
        "label" : "Last message",
        "value" : "'. $back_d  .  '"
      } 
	  
    ],
    "primaryFields": [
      {
        "key": "event",
        "label": "'   . $prim_a  . '",
        "value": "'   . $offprice. " % off "     . '"
      }
    ],
	
	 "secondaryFields": [
      {
        "key": "custom",
        "label": "CUSTOMER",
        "value": "'. $guestname. " ". $guestsurname.  '"
      },
	  {
        "key": "expires",
        "label": "EXPIRES",
        "value": "'. $sec_c.  '"
      } 
	  
    ]
	
  },
  
  "locations" : ' .$LOCATIONS. ' ,
  "beacons" : ' .$BEACONS. ' ,
  "associatedStoreIdentifiers":[731511649],
  "expirationDate": "'  . $expiresdate. '",
  "foregroundColor": "'.$foregroundcolor.'",
  "backgroundColor": "'.$backgroundcolor.'",
  "authenticationToken": "'.$authenticationtoken.'",
  "webServiceURL" : "'.'https://www.creationadv.gr/ihotelweb/vadmin/passbook/restapi/'.$guestcode.'",
  "labelColor":"'.$labelcolor.'",
  "formatVersion": 1,
  "logoText": "'. $logotext . '",
  "organizationName": "'.$organizationname. '",
  "passTypeIdentifier": "'.$passTypeIdentifier.'",
  "serialNumber": "'."AH1"."-". $guestcode.'",
  "teamIdentifier": "CYUW3U5C68" 
  
}';

?>