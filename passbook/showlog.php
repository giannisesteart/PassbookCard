<?php
 require_once ("../PHPUtil/config.php");

 function getPage($stmt, $pageNum, $rowsPerPage) 
{ 
    $offset = ($pageNum - 1) * $rowsPerPage; 
    $rows = array(); 
    $i = 0; 
    while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC, SQLSRV_SCROLL_ABSOLUTE, $offset + $i) 
           && $i < $rowsPerPage) 
    {   
	    var_dump ($row);
        array_push($rows, $row); 
        $i++; 
    } 
    return $rows; 
}
 
$connms = sqlsrv_connect ($mssql_host , $connectioninfo); //returns false
if( $connms === false ){
    echo "failed connection ";
	die( print_r( sqlsrv_errors(), true));
 }
  
 if( (! isset($_GET['hotelcode'])) || (! isset($_GET['guestcode']) ) ) {
        echo "Error in action parameters. Set hotel and ";
        die();
    }  
 $GUESTCODE =   $_GET['guestcode'];
 $HOTELCODE=   $_GET['hotelcode'];


$sql = "SELECT * FROM PASSLOG WHERE hotelcode= ". $HOTELCODE. " AND guestcode=" . $GUESTCODE. " ORDER BY serialnumber ASC , updatet_at DESC ;"  ;
 
$x =  ["Scrollable" =>'static' ];
$stmt = sqlsrv_query($connms, 
                     $sql, 
                     array() , 
                     $x );

 if( $stmt === false)
  {
     echo "Error in query preparation/execution showlogs .\n";
     die( print_r( sqlsrv_errors(), true));
  }
  
  
  // Set the number of rows to be returned on a page. 
$rowsPerPage = 17;

// Get the total number of rows returned by the query.  
$rowsReturned = sqlsrv_num_rows($stmt); 


/*style */
echo '<style> td ,a,p {  color:#666666;
	                background: #f4f8fc;
	                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                    font-size: 12px } 
				td {
                text-align:center;
				padding-left:15px;
				padding-right:15px;
				padding-top:8px;
				padding-bottom:8px;
				}				
					
					</style>'; 

echo "<div align='center'> <table style='padding:10px;'>"; 
echo "<tr>      <td bgcolor=#F1F1F1 align='center' height=30 > Serialnumber</td>
	            <td bgcolor=#F1F1F1 align='center'> Updated at</td>
				<td bgcolor=#F1F1F1 align='center'> Expires</td>
	            <td bgcolor=#F1F1F1 align='center' > Log Information</td>
		 </tr>";
		 








if($rowsReturned === false) 
    die( print_r( sqlsrv_errors(), true)); 
elseif($rowsReturned == 0) 
{ 
    echo "<p>No passbooks yet.</p>"; 
    exit(); 
} 
else 
{     
    /* Calculate number of pages. */ 
    $numOfPages = ceil($rowsReturned/$rowsPerPage); 
}


// Display the selected page of data. 

$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1; 
/*$page = getPage($stmt, $pageNum, $rowsPerPage);
var_dump ($page);*/
$i = 0; 
$offset = ($pageNum - 1) * $rowsPerPage;


while(($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_NUMERIC, SQLSRV_SCROLL_ABSOLUTE, $offset + $i))  && ($i < $rowsPerPage)) {
    
	$serial= $row[3];
	$updatet = date_format($row[4],'d-m-Y H:i');
	$logtext = $row[5];
	$expires = date_format($row[6],'d-m-Y');
	if (date_format($row[6],'Y')=="1900")$expires = "Never";
	 
    echo "<tr>  <td > $serial</td>
	            <td > $updatet</td>
				<td > $expires</td>
	            <td > $logtext</td>
		 </tr>";
    
	$i++;
}
echo "</table><br />";

echo " <p> Page ".$pageNum ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>      ";
  
 for($i = 1; $i<=$numOfPages; $i++)  
{  
    $pageLink = "?pageNum=$i"."&hotelcode=".$HOTELCODE."&guestcode=".$GUESTCODE;  
    print("<a href=$pageLink>$i</a>&nbsp;&nbsp;");  
}
// Display Previous Page link if applicable. 
if($pageNum > 1) 
{ 
    $prevPageLink = "?pageNum=".($pageNum - 1)."&hotelcode=".$HOTELCODE."&guestcode=".$GUESTCODE; 
    echo "<a href='$prevPageLink'>Previous Page</a>"; 
}

// Display Next Page link if applicable. 
if($pageNum < $numOfPages) 
{ 
    $nextPageLink = "?pageNum=".($pageNum + 1)."&hotelcode=".$HOTELCODE."&guestcode=".$GUESTCODE; 
    echo "&nbsp;&nbsp;<a href='$nextPageLink'>Next Page</a>"; 
}
 
 echo "</div>"
  
?>
