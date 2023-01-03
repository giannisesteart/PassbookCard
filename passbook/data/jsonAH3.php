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
  "eventTicket": {
	
	 "headerFields" : [
      {
        "key" : "header",
		"label" : "MEMBER",
        "value" : " '.  $Member . '"
		
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
        "value" : " No Expires"
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
        "key": "points",
        "label": "'   . ""  . '",
        "value": "'   . $Memberpoints . '",
		"changeMessage" : "You have %@ reward points"
      },
	   {
        "key": "pointsdesc",
        "label": "'   . ""  . '",
        "value": "'   . $Points . '"
		 
      }
    ],
	
	 "secondaryFields": [
      {
        "key": "custom",
        "label": "NIGHTS YTD",
        "value": "'. $Nights.  '"
      },
	  {
        "key": "stays",
        "label": "STAYS YTD",
        "value": "'. $Stays.  '"
      } ,
	   {
        "key": "nigthsin",
        "label": "'. $Labelmember.  '",
        "value": "'. $Invalue. '"
      } 
    ]
	
  },
  
  "locations" : ' .$LOCATIONS. ' ,
  "beacons" : ' .$BEACONS. ' ,
  "associatedStoreIdentifiers":[731511649],
  "foregroundColor": "'.$foregroundcolor.'",
  "backgroundColor": "'.$backgroundcolor.'",
  "authenticationToken": "'.$authenticationtoken.'",
  "webServiceURL" : "'.'https://www.creationadv.gr/ihotelweb/vadmin/passbook/restapi/'.$guestcode.'",
  "labelColor":"'.$labelcolor.'",
  "formatVersion": 1,
  "logoText": "'. $logotext . '",
  "organizationName": "'.$organizationname. '",
  "passTypeIdentifier": "'.$passTypeIdentifier.'",
   "serialNumber": "'."AH3"."-". $guestcode.'",
  "teamIdentifier": "CYUW3U5C68"
  
}';

?>