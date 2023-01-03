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
 
  "generic": {
	
	 "headerFields" : [
      {
        "key" : "header",
		"label" : "RESERVATION No",
        "value" : "'. $bookingid . '"
       
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
        "value" : "'  .$checkoutdate  .  '"
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
        "key": "member",
        "label": "GUEST",
        "value": "'. $guestname. " ". $guestsurname.  '"
      }
    ],
	
	
	 "secondaryFields": [
      {
        "key": "roomtypeid",
        "label": "ROOMTYPE",
        "value": "'. $typeofroom.  '"
      },
	  {
        "key": "rateid",
        "label": "RATE",
        "value": '. $reservationprice.  ',
		 "currencyCode" : "EUR"
      } 
	  ],
	  
	  "auxiliaryFields" : [
      {
        "key" : "checkindate",
        "label" :"' . $nights." NIGHTS". '",
        "value" : "' .$checkindate.  " To "  .$checkoutdate. '"
      }  
	  ]
	
   
	  
  },
	
	
  
  "locations" : ' .$LOCATIONS. ' ,
  "beacons" : ' .$BEACONS. ' ,
  "associatedStoreIdentifiers":[731511649],
  "expirationDate": "'  .$expiresdate. '",
  "foregroundColor": "'.$foregroundcolor.'",
  "backgroundColor": "'.$backgroundcolor.'",
  "labelColor":"'.$labelcolor.'",
  "formatVersion": 1,
  "logoText": "'. $logotext . '",
  "organizationName": "'.$organizationname. '",
  "passTypeIdentifier": "'.$passTypeIdentifier.'",
  "serialNumber": "AH2",
  "teamIdentifier": "CYUW3U5C68"
  
}';

?>