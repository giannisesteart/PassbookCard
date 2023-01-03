<?php
     //This is the rules section for the specific Passbook Card
    //Here can calculate values or set integritychecks 

      require_once ($MYROOT."/PHPUtil/phputil.php");
 
    //******* open and select data from Passbook 
     require_once ($MYROOT."/PHPUtil/config.php");
		 
	   
       function memberfn  ($nigthsorstays ,$silver,$gold, $platinum)
	   {
		   if ($nigthsorstays< $silver) return  array ("STANDARD" , "".$silver-$nigthsorstays, "SILVER IN") ;
		   if (($nigthsorstays>= $silver) && ($nigthsorstays<$gold)) return array ("SILVER" , "".$gold-$nigthsorstays, "GOLD IN") ;
		   if (($nigthsorstays>= $gold) && ($nigthsorstays<$platinum)) return array("GOLD" , "".$platinum-$nigthsorstays, "PLATINUM IN");
		   if ($nigthsorstays>= $platinum ) return array( "PLATINUM", "", "") ;
		
	   }
	   
	    
	   
	   
	   //Fetch Rewards and Rates for calculation
    
	   $connms = sqlsrv_connect ($mssql_host , $connectioninfo);
	  
	   $sql = "SELECT * FROM REWARDS WHERE hotelcode=" . $HOTELCODE. ";"  ;
	   $stmt = sqlsrv_query($connms,$sql); 
	   if( $stmt === false)
	   {
		 echo "Error in query preparation/execution rules AH3.\n";
		 die( print_r( sqlsrv_errors(), true));
	   }
	   $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	   if( ! $rec  ) { //Reward system not existent
	      echo "No rewards table for Hotel $HOTELCODE AH3.\n";
		  die();
	   }
       
		  $Rewtitle =$rec['Rewtitle'];
		  $ESilverMinNights = $rec['ESilverMinNights'];
          $ESilverMinStay =  $rec['ESilverMinStay'];
         // $ESilverMaxQuantity = $rec['ESilverMaxQuantity'];

          $EGoldMinNights   =  $rec [ 'EGoldMinNights'];
          $EGoldMinStay =  $rec [ 'EGoldMinStay'];
         // $EGoldMaxQuantity = $rec [ 'EGoldMaxQuantity'];

		  $EPlatinumMinNights   =  $rec [ 'EPlatinumMinNights'];
          $EPlatinumMinStay =  $rec [ 'EPlatinumMinStay'];
         // $EPlatinumMaxQuantity = $rec [ 'EPlatinumMaxQuantity'];
		  $typeofrewards =  $rec['typeofrewards'];
		  
		 $sql = "SELECT * FROM RATES WHERE guestcode=" . $GUESTCODE. ";"  ;
	     $stmt = sqlsrv_query($connms,$sql);
	     if( $stmt === false)
	     {
		   echo "Error in query preparation/execution rewards.\n";
		   die( print_r( sqlsrv_errors(), true));
	     }
		 $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	     if( ! $rec  ) { //insert Rate entry
		    echo "Customer  $GUESTCODE not found in Rates .\n";
		    die();
	      } 

		  /* If has pivot then take the pivotguest values*/
		  if ($rec['guestcode'] !=$rec['pivotguestcode']) {
		   $sql = "SELECT * FROM RATES WHERE guestcode=" . $rec['pivotguestcode']. ";"  ;
	       $stmt = sqlsrv_query($connms,$sql);
	       if( $stmt === false)
	         {
		    echo "Error in query preparation/execution rewards.\n";
		   die( print_r( sqlsrv_errors(), true));
	         }
		    $rec = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
	        if( ! $rec  ) { //insert Rate entry
		    echo "Customer Pivotguest".  $rec['pivotguestcode'] ." not found in Rates .\n";
		    die();
	       } 
          }
	      
        $Points =  $rec['Points'];
        $MaxQuantity = $rec['MaxQuantity'];
	    $EPointsFB = $rec [ 'EPointsFB'];
        $EPMobCheck = $rec [ 'EPointsMobCheck'];
        $EPointsStay = $rec['EPointsStay'];
        $EPointsRoomService =  $rec['EPointsRoomService'];
        $EPointsShopping = $rec['EPointsShopping'];
        $EPointsFirstSign  = $rec['EPointsFirstSign'];
        $EPointsLogin =  $rec['EPointsLogin']; 
	    $EPointsLogin =  $rec['EPointsLogin'];
		$EPointsMobBooking =  $rec['EPointsMobBooking'];
		$EPointsHotel =  $rec['EPointsHotel'];
		
	    $RewardsOn =$rec['RewardsOn'];
		
		 //**** calculate Card
		 
		 $Stays =  $rec['Stays'];
		 $Nights = $rec['Nights'];
		 
		 
		 $Memberpoints ="";
		 $Member ="";
		 $Labelmember="";
		 $Invalue ="";
		 
		if ($RewardsOn ==1) {
			$Memberpoints = " "	. ($Points + $EPointsFB + $EPMobCheck + $EPointsStay +$EPointsRoomService
                    		 +$EPointsShopping +$EPointsFirstSign  +$EPointsLogin+$EarnPointsMobile + ($EPointsHotel)) ;
		
    	 if ($typeofrewards == 0) { //Nights
		   $memberdata = memberfn ($Nights, $ESilverMinNights, $EGoldMinNights ,$EPlatinumMinNights);
		   $Member = $memberdata[0];
		   $Labelmember = $memberdata[2]   ;
		   $Invalue = $memberdata[1] . " NIGHTS";
		 } else { //1:stays
		   $memberdata = memberfn ($Stays, $ESilverMinStay, $EGoldMinStay ,$EPlatinumMinStay);
		   $Member = $memberdata[0];
		   $Labelmember = $memberdata[2]   ;
		   $Invalue = $memberdata[1] . " STAYS" ; 
		 }
		 if ($Member =="PLATINUM"){
		      $Labelmember = "YOUR CARD IS"  ;
		      $Invalue = "PLATINUM";
		   }
		 
		 $Points ="Points"; //print the text Points
		}  else {
			echo "no Rewards On for this guest" ;
			die ();
	    }
			
		
         
 /* *****Analytics *** LOGS FOR PASSBOOK ********************
  * The Aanalytics tracks the basic values
  * It set logtext that the client see in the guesttable
  * *****Analytics *** LOGS FOR PASSBOOK ********************/
  
 
  require_once ($MYROOT."/PHPUtil/common.php");
  $connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
  if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
  }
  
  $data =   array('hotelcode' => $HOTELCODE,
                   'guestcode' =>   $GUESTCODE ,
				   'serialnumber' => $SERIALNUMBER,
				   'logtext' =>   "MEMBER: ". $Member. " POINTS: ". $Memberpoints. " NIGHTS: ". $Nights. " STAYS: ". $Stays ,
				   'expiresdate' =>  '1900-01-01 00:00:00' //Never
				   );
				   
    
				   
 	   
	          		 
  $sql =   get_insert_query("PASSLOG", $data);
   
  
 
  $stmt = sqlsrv_query($connms,$sql);
   if( $stmt === false)
  {
     echo "Error in query preparation/execution PASSLOG.\n";
     die( print_r( sqlsrv_errors(), true));
  }
  sqlsrv_close ( $connms ) ;
 /*End Analytics */
 
  ?>