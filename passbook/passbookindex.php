<?php 
//******* Passbookindex Generator ******************************?
//******* The generator creates $variables for use in JSON
//******* Fetch the data from PASSBOOKINDEX and stores in the variables
//*******

require_once ($MYROOT."/PHPUtil/phputil.php");
 
//******* open and select data from Passbook 
require_once ($MYROOT."/PHPUtil/config.php");
		 

		 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
if( $connms === false )
{
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
}


// Querie Must be ORDERED to JSONFIELD while parse is contextsensitive
  
if ($GUESTCODE == "0")
$sql = "SELECT * FROM PASSBOOKINDEX  WHERE hotelcode= " . $HOTELCODE . " AND serialnumber = '"  .$SERIALNUMBER. "'  ORDER BY jsonfield ASC ;"  ;
else
$sql = "SELECT * FROM PASSBOOKINDEX  WHERE  serialnumber = '"  .$SERIALNUMBER.  " '  AND " .       
                                "  hotelcode= " . $HOTELCODE . "  AND  ( (guestcode IS NULL)  OR ( guestcode= " . $GUESTCODE . " ) ) ORDER BY jsonfield ASC ;"  ; 
	//"  AND  guestcode= NULL)
	
	 
	
$stmt = sqlsrv_query($connms,$sql);
   
if( $stmt === false)
  { 
     echo "Error in query preparation/execution PB-index 2.\n";
	 echo  $HOTELCODE."-". $GUESTCODE."-".$SERIALNUMBER;
     die( print_r( sqlsrv_errors(), true));
  }
   

 // Map of Locations and beacons
 
$map   = array();
function  init_mapentry () {
	
  global $map;
	
  array_push($map, 
              array(
             'latitude' => 0,
             'longitude' => 0,
             'relevantText' => '',
             )
         );
	
}
  
$beac   = array();

function  init_beacentry () {
	
  global $beac;
	
  array_push($beac, 
              array(
			 'proximityUUID' => "",
             'major' => 0,
             'minor' => 0,
             'relevantText' => '',
             )
         );
	
}
 
//$rec is ready fill the JSON with  data from DB
  while ( $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
   
//***********************************************************************
//  Switch is extendible in the same systematic.
//  At first we have 10keys pro group 
// 	You can add the HOTEL and HOTEL_GUESTS	in the same maner as PRIM_Z_HOTEL ...PRIM_Z_HOTEL_GUEST
//  Note PRIM_Z_HOTEL is the first record and PRIM_Z_HOTEL_GUEST second. With sort of query ASC then
//  we have the effect!!: if PRIM_Z_HOTEL not is set and PRIM_Z_HOTEL_GUEST is 
//    set then set the PRIM_Z_HOTEL_GUEST value in JSON variables
// Also: if HOTEL take PRIM_Z_HOTEL else if Customer PRIM_Z_HOTEL_GUEST
//***********************************************************************

$jsonfield = ms_escape_string ( $rec['jsonfield']   ) ;

//echo "jsonf=".$jsonfield." value =".$rec['value'] ."<br>" ;

switch ($jsonfield) {
	
	// GROUP HEAD FIELDS - for the head section 
    case "HEAD_A_HOTEL":
    case "HEAD_A_HOTEL_GUEST":
        $head_a = $rec['value'];
        break;
	case "HEAD_B_HOTEL":
    case "HEAD_B_HOTEL_GUEST":
        $head_b= $rec['value'] ;
        break;
    case "HEAD_C_HOTEL":
    case "HEAD_C_HOTEL_GUEST":
        $head_c = $rec['value'] ;  
        break;
    case "HEAD_D_HOTEL":
    case "HEAD_D_HOTEL_GUEST":
        $head_d = $rec['value'];
        break;
	case "HEAD_E_HOTEL":    
    case "HEAD_E_HOTEL_GUEST":
        $head_e = $rec['value']; 
        break;	
	 
    case "HEAD_F_HOTEL":
    case "HEAD_F_HOTEL_GUEST":
        $head_f = $rec['value'];
        break;
	case "HEAD_G_HOTEL":
    case "HEAD_G_HOTEL_GUEST":
        $head_g= $rec['value'] ;
        break;
    case "HEAD_H_HOTEL":
    case "HEAD_H_HOTEL_GUEST":
        $head_h = $rec['value'] ;  
        break;
    case "HEAD_I_HOTEL":
    case "HEAD_I_HOTEL_GUEST":
        $head_i = $rec['value'];
        break;
	case "HEAD_J_HOTEL":    
    case "HEAD_J_HOTEL_GUEST":
        $head_j = $rec['value']; 
        break;	
	 
		
	// GROUP PRIMARY FIELDS - for the head section 
    case "PRIM_A_HOTEL":
    case "PRIM_A_HOTEL_GUEST":
        $prim_a = $rec['value'];  
        break;
	case "PRIM_B_HOTEL":
    case "PRIM_B_HOTEL_GUEST":
        $prim_b = $rec['value']; 
        break;
    case "PRIM_C_HOTEL":
    case "PRIM_C_HOTEL_GUEST":
        $prim_c = $rec['value'];  
        break;
    case "PRIM_D_HOTEL":
    case "PRIM_D_HOTEL_GUEST":
        $prim_d=  $rec['value'];
        break;
	case "PRIM_E_HOTEL":
    case "PRIM_E_HOTEL_GUEST":
        $prim_e= $rec['value'] ;
        break;	

    case "PRIM_F_HOTEL":
    case "PRIM_F_HOTEL_GUEST":
        $prim_f = $rec['value'];  
        break;
	case "PRIM_G_HOTEL":
    case "PRIM_G_HOTEL_GUEST":
        $prim_g = $rec['value']; 
        break;
    case "PRIM_H_HOTEL":
    case "PRIM_H_HOTEL_GUEST":
        $prim_g = $rec['value'];  
        break;
    case "PRIM_I_HOTEL":
    case "PRIM_I_HOTEL_GUEST":
        $prim_i=  $rec['value'];
        break;
	case "PRIM_J_HOTEL":
    case "PRIM_J_HOTEL_GUEST":
        $prim_j= $rec['value'] ;
        break;	
	
	// GROUP SECONDARY FIELDS - for the head section 
     
    case "SEC_A_HOTEL":
    case "SEC_A_HOTEL_GUEST":
        $sec_a = $rec['value'];  
        break;
	case "SEC_B_HOTEL":
    case "SEC_B_HOTEL_GUEST":
        $sec_b = $rec['value']; 
        break;
    case "SEC_C_HOTEL":
    case "SEC_C_HOTEL_GUEST":
        $sec_c = $rec['value'];  
		
        break;
    case "SEC_D_HOTEL":
    case "SEC_D_HOTEL_GUEST":
        $sec_d=  $rec['value'];
        break;
	case "SEC_E_HOTEL":
    case "SEC_E_HOTEL_GUEST":
        $sec_e= $rec['value'] ;
        break;	
  
    case "SEC_F_HOTEL":
    case "SEC_F_HOTEL_GUEST":
        $sec_f = $rec['value'];  
        break;
	case "SEC_G_HOTEL":
    case "SEC_G_HOTEL_GUEST":
        $sec_g = $rec['value']; 
        break;
    case "SEC_H_HOTEL":
    case "SEC_H_HOTEL_GUEST":
        $sec_h = $rec['value'];  
        break;
    case "SEC_I_HOTEL":
    case "SEC_I_HOTEL_GUEST":
        $sec_i=  $rec['value'];
        break;
	case "SEC_J_HOTEL":
    case "SEC_J_HOTEL_GUEST":
        $sec_j= $rec['value'] ;
        break;	
		
		// GROUP AUXILIARYFIELDS - for the  uxiliary section 
     
    case "AUX_A_HOTEL":
    case "AUX_A_HOTEL_GUEST":
        $aux_a = $rec['value'];  
        break;
	case "AUX_B_HOTEL":
    case "AUX_B_HOTEL_GUEST":
        $aux_b = $rec['value']; 
        break;
    case "AUX_C_HOTEL":
    case "AUX_C_HOTEL_GUEST":
        $aux_c = $rec['value'];  
        break;
    case "AUX_D_HOTEL":
    case "AUX_D_HOTEL_GUEST":
        $aux_d=  $rec['value'];
        break;
	case "AUX_E_HOTEL":
    case "AUX_E_HOTEL_GUEST":
        $aux_e= $rec['value'] ;
        break;	
	  
    case "AUX_F_HOTEL":
    case "AUX_F_HOTEL_GUEST":
        $aux_f = $rec['value'];  
        break;
	case "AUX_G_HOTEL":
    case "AUX_G_HOTEL_GUEST":
        $aux_g = $rec['value']; 
        break;
    case "AUX_H_HOTEL":
    case "AUX_H_HOTEL_GUEST":
        $aux_h = $rec['value'];  
        break;
    case "AUX_I_HOTEL":
    case "AUX_I_HOTEL_GUEST":
        $aux_i=  $rec['value'];
        break;
	case "AUX_J_HOTEL":
    case "AUX_J_HOTEL_GUEST":
        $aux_j= $rec['value'] ;
        break;	
		
		// GROUP BACK - for the Back section 
     
    case "BACK_A_HOTEL":
    case "BACK_A_HOTEL_GUEST":
        $back_a = $rec['value'];  
        break;
	case "BACK_B_HOTEL":
    case "BACK_B_HOTEL_GUEST":
        $back_b = $rec['value']; 
        break;
    case "BACK_C_HOTEL":
    case "BACK_C_HOTEL_GUEST":
        $back_c = $rec['value'];  
        break;
    case "BACK_D_HOTEL":
    case "BACK_D_HOTEL_GUEST":
        $back_d=  $rec['value'];
        break;
	case "BACK_E_HOTEL":
    case "BACK_E_HOTEL_GUEST":
        $back_e= $rec['value'] ;
        break;	
	
	case "BACK_F_HOTEL":
    case "BACK_F_HOTEL_GUEST":
        $back_f = $rec['value'];  
        break;
	case "BACK_G_HOTEL":
    case "BACK_G_HOTEL_GUEST":
        $back_g = $rec['value']; 
        break;
    case "BACK_H_HOTEL":
    case "BACK_H_HOTEL_GUEST":
        $back_h = $rec['value'];  
        break;
    case "BACK_I_HOTEL":
    case "BACK_I_HOTEL_GUEST":
        $back_i=  $rec['value'];
        break;
		
	case "BACK_J_HOTEL":
    case "BACK_J_HOTEL_GUEST":
        $back_j= $rec['value'] ;
        break;	
	
	//Locations 
	// init_mapentry (); initializes the array (Atention !!) at the first Attribute
	//**************
	case "LOC_A_LA_HOTEL":
	      init_mapentry ();
		  $map[0]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_A_LO_HOTEL":
		  $map[0]['longitude']=(double)  $rec['value'] ;
		  break;

    case "LOC_A_ME_HOTEL":
		  $map[0]['relevantText']=$rec['value'] ;
		  break;
		  
	
	
	//**************
	case "LOC_B_LA_HOTEL":
	      init_mapentry ();
		  $map[1]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_B_LO_HOTEL":
		  $map[1]['longitude']=(double) $rec['value'] ;
		  break;

    case "LOC_B_ME_HOTEL":
		  $map[1]['relevantText']=  $rec['value'] ;
		  break;
	
	
	//**************
	case "LOC_C_LA_HOTEL":
	      init_mapentry ();
		  $map[2]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_C_LO_HOTEL":
		  $map[2]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_C_ME_HOTEL":
		  $map[2]['relevantText']=$rec['value'] ;
		  break;
	
	
	//**************
	case "LOC_D_LA_HOTEL":
	      init_mapentry ();
		  $map[3]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_D_LO_HOTEL":
		  $map[3]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_D_ME_HOTEL":
		  $map[3]['relevantText']=$rec['value'] ;
		  break;
		  
	
	//**************
	case "LOC_E_LA_HOTEL":
	      init_mapentry ();
		  $map[4]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_E_LO_HOTEL":
		  $map[4]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_E_ME_HOTEL":
		  $map[4]['relevantText']=$rec['value'] ;
		  break;
	
	
	
	//**************
	case "LOC_F_LA_HOTEL":
	      init_mapentry ();
		  $map[5]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_F_LO_HOTEL":
		  $map[5]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_F_ME_HOTEL":
		  $map[5]['relevantText']=$rec['value'] ;
		  break;
	
	
	
	
	//**************
	case "LOC_G_LA_HOTEL":
	      init_mapentry ();
		  $map[6]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_G_LO_HOTEL":
		  $map[6]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_G_ME_HOTEL":
		  $map[6]['relevantText']=$rec['value'] ;
		  break;
	
	
	//**************
	case "LOC_H_LA_HOTEL":
	      init_mapentry ();
		  $map[7]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_H_LO_HOTEL":
		  $map[7]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_H_ME_HOTEL":
		  $map[7]['relevantText']=$rec['value'] ;
		  break;
	
	
	//**************
	case "LOC_I_LA_HOTEL":
	      init_mapentry ();
		  $map[8]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_I_LO_HOTEL":
		  $map[8]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_I_ME_HOTEL":
		  $map[8]['relevantText']=$rec['value'] ;
		  break;
		  
		
	//**************
	case "LOC_J_LA_HOTEL":
	      init_mapentry ();
		  $map[9]['latitude']= (double) $rec['value'] ;
		  break;
		  
	case "LOC_J_LO_HOTEL":
		  $map[9]['longitude']= (double) $rec['value'] ;
		  break;

    case "LOC_J_ME_HOTEL":
		  $map[9]['relevantText']=$rec['value'] ;
		  break;  
		  
		  
	
	
	
	
	//**********************Beacons!!******************************/
	//  init_beacentry (); initializes the Beacon at first!!!! attribute
	//**************
	
	case "BEAC_A_APRO_HOTEL":
	      init_beacentry ();
		  $beac[0]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_A_MA_HOTEL":
		  $beac[0]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_A_MI_HOTEL":
		 $beac[0]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_A_ME_HOTEL":
		 
		 $beac[0][ 'relevantText'] = $rec['value'] ;
		  break;	  
	 
	//**************

	
	case "BEAC_B_APRO_HOTEL":
	      init_beacentry ();
		  $beac[1]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_B_MA_HOTEL":
		  $beac[1]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_B_MI_HOTEL":
		 $beac[1]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_B_ME_HOTEL":
		 
		 $beac[1][ 'relevantText'] = $rec['value'] ;
		  break;
	 
	 //**************

	
	case "BEAC_C_APRO_HOTEL":
	      init_beacentry ();
		  $beac[2]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_C_MA_HOTEL":
		  $beac[2]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_C_MI_HOTEL":
		 $beac[2]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_C_ME_HOTEL":
		 
		 $beac[2][ 'relevantText'] = $rec['value'] ;
		  break;
	 
	 
	  //**************

	
	case "BEAC_D_APRO_HOTEL":
	      init_beacentry ();
		  $beac[3]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_D_MA_HOTEL":
		  $beac[3]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_D_MI_HOTEL":
		 $beac[3]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_D_ME_HOTEL":
		 
		 $beac[3][ 'relevantText'] = $rec['value'] ;
		  break;
	 
	
	 //**************

	
	case "BEAC_E_APRO_HOTEL":
	      init_beacentry ();
		  $beac[4]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_E_MA_HOTEL":
		  $beac[4]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_E_MI_HOTEL":
		 $beac[4]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_E_ME_HOTEL":
		 
		 $beac[4][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	 //**************

	
	case "BEAC_F_APRO_HOTEL":
	      init_beacentry ();
		  $beac[5]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_F_MA_HOTEL":
		  $beac[5]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_F_MI_HOTEL":
		 $beac[5]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_F_ME_HOTEL":
		 
		 $beac[5][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	
	 //**************

	
	case "BEAC_G_APRO_HOTEL":
	      init_beacentry ();
		  $beac[6]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_G_MA_HOTEL":
		  $beac[6]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_G_MI_HOTEL":
		 $beac[6]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_G_ME_HOTEL":
		 
		 $beac[6][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	
	 //**************

	
	case "BEAC_H_APRO_HOTEL":
	      init_beacentry ();
		  $beac[7]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_H_MA_HOTEL":
		  $beac[7]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_H_MI_HOTEL":
		 $beac[7]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_H_ME_HOTEL":
		 
		 $beac[7][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	//**************

	
	case "BEAC_I_APRO_HOTEL":
	      init_beacentry ();
		  $beac[8]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_I_MA_HOTEL":
		  $beac[8]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_I_MI_HOTEL":
		 $beac[8]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_I_ME_HOTEL":
		 
		 $beac[8][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	//**************

	
	case "BEAC_J_APRO_HOTEL":
	      init_beacentry ();
		  $beac[9]['proximityUUID']=   $rec['value'] ;
		  break;
	
	case "BEAC_J_MA_HOTEL":
		  $beac[9]['major']=  intval ( $rec['value'] ) ;  
		  break;
	

    case "BEAC_J_MI_HOTEL":
		 $beac[9]['minor']=  intval ( $rec['value'] ) ;
		  break;
	
	
    case "BEAC_J_ME_HOTEL":
		 
		 $beac[9][ 'relevantText'] = $rec['value'] ;
		  break;
	
	
	
		// else error  
		
		
	default: echo ("You have a error by setting the fieldsname : " . $jsonfield ." in the site; Ten values are allowed a, b,c,d,e,....<br/>");
	         echo ("Example: HEAD_E_HOTEL_GUEST , HEAD_E_HOTEL <br/>");
	         echo ("Nameconvention: PRIM_A_HOTEL_GUEST , SEC_E_HOTEL , AUX_E_HOTEL, BACK_E_HOTEL, HEAD_E_HOTEL_GUEST <br/>");
			 break;
   } //end switch


  } //end while
  
  
 
     
 $LOCATIONS = json_encode($map, JSON_NUMERIC_CHECK);
 $BEACONS   = json_encode($beac, JSON_NUMERIC_CHECK);
 
 
  //debug
 if (FALSE){
	 echo "**************************";
	 echo $LOCATIONS;
	 echo "**************************";
	 echo $BEACONS;
 }
 
 
     //*** close
    sqlsrv_close ( $connms ) ;
  ?>